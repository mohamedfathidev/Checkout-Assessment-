<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Paytabscom\Laravel_paytabs\Facades\paypage;

class PaymentService
{
    public function initiatePayment(Order $order, array $billing)
    {
        try {
            $payment_method = "all";
            $tran_type = "sale";
            $tran_class = "ecom";
            $cart_id = $order->id;
            $cart_amount = $order->total_amount;
            $cart_description = $order->description;
            $name = $billing['name'];
            $email = $billing['email'];
            $phone = $billing['phone'];
            $street1 = $billing['street1'];
            $city = $billing['city'];
            $state = $billing['state'];
            $country = $billing['country'];
            $zip = $billing['zip'];
            $ip = request()->ip();
            $return = env('NGROK_URL') . "/payment/return";
            $callback = env('NGROK_URL') . "/payment/callback";
            
            // Debug logging
            Log::info('Payment URLs set', [
                'return_url' => $return,
                'callback_url' => $callback,
                'ngrok_url' => env('NGROK_URL')
            ]);
            $language = "en";

            return paypage::sendPaymentCode($payment_method)
                ->sendTransaction($tran_type, $tran_class)
                ->sendCart($cart_id, $cart_amount, $cart_description)
                ->sendCustomerDetails($name, $email, $phone, $street1, $city, $state, $country, $zip, $ip)
                ->shipping_same_billing()
                ->sendHideShipping(false)
                ->sendURLs($return, $callback)
                ->sendLanguage($language)
                ->create_pay_page();
        } catch (\Exception $e) {
            Log::error('Payment initiation failed', ['error' => $e->getMessage()]);
            throw new \Exception('Unable to initiate payment. Please try again.');
        }
    }


    public function handleCallback(Request $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $tranRef = $request->input('tranRef') ?? $request->input('tran_ref');
                $transaction = paypage::queryTransaction($tranRef);

                $order = Order::where('id', $transaction->cart_id)->first();
            if (!$order) {
                Log::warning('Order not found for transaction: ' . $tranRef);
                throw new \Exception('Order not found');
            }

            if($transaction->payment_result->response_status == "E")
            {
                Log::warning('Order not found for transaction: ' . $tranRef);
                throw new \Exception('payment failed try again with different card');
            }

                // Update Order Status => paid 
                $order->status = 'paid';
                $order->save();
                // Store or update the Payment details in payments table in DB:
                $payment = Payment::where('tran_ref', $transaction->tran_ref)->first();
                if (!$payment) {
                    $payment = new Payment();
                    $payment->tran_ref = $transaction->tran_ref;
                }
                $payment->order_id = $order ? $order->id : null;
                $payment->customer_name = $transaction->customer_details->name ?? null;
                $payment->tran_type = $transaction->tran_type ?? null;
                $payment->amount = $transaction->cart_amount ?? null;
                $payment->currency = $transaction->cart_currency ?? null;
                $payment->payment_method = $transaction->payment_info->payment_method ?? null;
                $payment->status = $transaction->payment_result->response_status ?? null;
                $payment->save();

                return [
                    'order' => $order, 
                    'payment' => $payment, 
                    'transaction' => $transaction
                ];
            });
        } catch (\Exception $e) {
            Log::error('Payment callback failed', ['error' => $e->getMessage()]);
            throw new \Exception('Order not found, cannot update or store transaction '.$e->getMessage());        }
    }

    public function refundOrder($id)
    {
        $order = Order::find($id);
        $payment = Payment::where('order_id', $id)->first();
        $paymentTranTypes = $order->payments->pluck('tran_type')->toArray();
        $customerDetails = json_decode($order->customer_details);

        // order or payment Not Found
        if (!$order || !$payment) {
            return [
                'success' => false,
                'error' => 'Order or Payment not found',
                'status' => 404
            ];
        }

        // if this order already refunded 
        if (in_array("Refund", $paymentTranTypes)) {
            return [
                "success" => false,
                "error" => "This Order already fully refunded before",
                "status" => 404
            ];
        }

        // Creedinitials 
        $serverKey = config('paytabs.server_key');
        $profileId = config('paytabs.profile_id');

        if (!$serverKey || !$profileId) {
            return [
                'success' => false,
                'error' => 'Server key or Profile ID is not configured properly.',
                'status' => 500
            ];
        }

        $payload = [
            "profile_id" => $profileId,
            "tran_type" => "refund",
            "tran_class" => "ecom",
            "cart_id" => (string)$id, // Field cart_id must be type string
            "cart_currency" => $order->currency,
            "cart_amount" => $order->total_amount,
            "cart_description" => "Refund for order #{$id}",
            "tran_ref" => $payment->tran_ref,
            "customer_details" => [
                "name" => $customerDetails->billing->name ?? null,
                "email" => $customerDetails->billing->email ?? null,
                "phone" => $customerDetails->billing->phone ?? null,
                "street1" => $customerDetails->billing->street1 ?? null,
                "city" => $customerDetails->billing->city ?? null,
                "state" => $customerDetails->billing->state ?? null,
                "country" => $customerDetails->billing->country ?? null,
                "zip" => $customerDetails->billing->zip ?? null,
            ]
        ];

        $response = Http::withHeaders([
            'Authorization' => $serverKey,
            'Content-Type' => 'application/json',
        ])->post('https://secure-egypt.paytabs.com/payment/request', $payload);

        $data = $response->json(); // associative array 

        if (isset($data['payment_result']['response_status']) && $data['payment_result']['response_status'] === 'A') {
            // Create a new Payment record for the refund
            Payment::create([
                'order_id' => $order->id,
                'tran_ref' => $data['tran_ref'] ?? $payment->tran_ref,
                'customer_name' => $payment->customer_name ?? null,
                'tran_type' => 'Refund',
                'amount' => $order->total_amount,
                'currency' => $order->currency,
                'payment_method' => $payment->payment_method ?? null,
                'status' => $data['payment_result']['response_status'],
            ]);



            return [
                'success' => true,
                'message' => 'Refund successful',
                'data' => $data
            ];
        } else {
            $errorMessage = $data['payment_result']['response_message'] ?? 'Refund failed';
            $responseCode = $data['payment_result']['response_code'] ?? null;
            $errorDetails = match ($responseCode) {
                '320' => 'Unable to refund - Transaction may not be eligible for refund (too old, already refunded, or card issuer declined)',
                '321' => 'Refund amount exceeds original transaction amount',
                '322' => 'Transaction not found or invalid transaction reference',
                '323' => 'Refund not allowed for this transaction type',
                default => $errorMessage . " this",
            };
            Log::warning("PayTabs Refund Failed - Order: {$id}, Code: {$responseCode}, Message: {$errorDetails}");
            return [
                'success' => false,
                'message' => 'Refund failed',
                'error' => $errorDetails,
                'response_code' => $responseCode,
                'data' => $data,
                'status' => 400
            ];
        }
    }
}
