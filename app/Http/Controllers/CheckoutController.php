<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Services\ValidationService;
use Paytabscom\Laravel_paytabs\Facades\paypage;
use App\Services\PaymentService;

class CheckoutController extends Controller
{
    protected $validationService;
    protected $paymentService;

    public function __construct(ValidationService $validationService, PaymentService $paymentService)
    {
        $this->validationService = $validationService;
        $this->paymentService = $paymentService;
    }

    public function showDetailsForm($orderId): View
    {
        return view('checkout-details', compact("orderId"));
    }


    public function checkout(Request $request, Order $order)
{
    $request->validate($this->validationService->getValidationRules("billing"));

    $data = $request->all();

    if ($request->has('same_as_billing')) {
        $data['shipping'] = $data['billing'];
    } else {
        $request->validate($this->validationService->getValidationRules("shipping"));
    }

    $billing = $data['billing'];
    $shipping = $data['shipping'] ?? $billing;

    $customerInfo = json_encode([
        'billing' => $billing,
        'shipping' => $shipping,
    ]);

    $order->fill([
        "customer_details" => $customerInfo,
    ])->save();

    return $this->paymentService->initiatePayment($order, $billing);
}

    public function handleReturnUrl(Request $request)
    {
        $tranRef = $request->input('tranRef') ?? $request->input('tran_ref');
        $transaction = paypage::queryTransaction($tranRef);

        $message = $transaction->payment_result->response_message ?? 'Unknown status';

        if ($transaction && $transaction->payment_result->response_status === 'A') {
            // Success
            return redirect()->route('payment.success', $transaction->cart_id)->with('message', $message);
        } else {
            // Failure
            return redirect()->route('payment.failure')->with('message', $message);
        }
    }
    public function paymentSuccess(Request $request, ?int $id = null)
    {
        // Log the full transaction info for debugging
        \Log::info('PayTabs Return URL Response:', $request->all());



        return view('payment-success', compact('id'));
    }


    public function paymentCallback(Request $request)
    {
        // Log the full transaction info for debugging
        \Log::info('PayTabs Callback Response:', $request->all());

        // Use PaymentService to handle callback
        $data = $this->paymentService->handleCallback($request);

        return response()->json(["status" => true, "message" => "callback received", "data" => $data]);
    }

    public function fullRefund(Order $order)
    {
        $result = $this->paymentService->refundOrder($order->id);
            
        if ($result['success']) {
            return redirect()->route('payment.success')->with('message', $result['message']);
        } else {
            return redirect()->route('payment.failure')->with('message', $result['error'] ?? 'Refund failed');
        }
    }

    public function paymentFailure()
    {

        return view('payment-failure');
    }
}
