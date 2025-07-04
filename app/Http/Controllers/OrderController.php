<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class OrderController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
      try {
        $request->validate([
            'description' => 'required',
            "total_amount" => 'required|numeric'
        ]);

        // delivery method set by default to shipping always in DB, status also to pending, currecny => EGY
        $order = Order::create([
            "description" => $request->description,
            "total_amount" => $request->total_amount,
        ]);


        return redirect()->route('show.details.form', $order->id)
            ->with('success', 'Order created now fill the billing & shipping info');

        } catch(\Exception $e) {
            return redirect()->route('error')->with('error', 'Unable to create order.');
        }

    }
}
