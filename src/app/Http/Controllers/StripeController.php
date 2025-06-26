<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Http\Requests\PurchaseRequest;



class StripeController extends Controller {

    public function createSession(PurchaseRequest $request, $id)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $item = Item::find($id);
        $user = Auth::user();
        $paymentMethod = $request->input('payment_method');

        $order = Order::where('user_id', $user->id)
        ->where('item_id', $item->id)
        ->first();

        if (!$order) {
            $order = Order::create([
                'user_id' => $user->id,
                'item_id' => $item->id,
                'payment_method_id' => $paymentMethod === 'convenience' ? 1 : 2,
                'paid_at' => null,
            ]);
        }
            $session = Session::create([
            'payment_method_types' => [$paymentMethod === 'convenience' ? 'konbini' : 'card'],
            'mode' => 'payment',
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'unit_amount' => $item->price,
                    'product_data' => ['name' => $item->name],
                ],
                'quantity' => 1,
            ]],
            'success_url' => route('purchase.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'metadata' => [
                'user_id' => $user->id,
                'item_id' => $item->id,
                'payment_method' => $paymentMethod,
                'order_id' => $order->id,
            ],
        ]);

        return redirect($session->url);
    }

    public function success(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $sessionId = $request->get('session_id');
        if (!$sessionId) {
            return redirect('/')->with('error', '決済情報が見つかりません');
        }

        $session = Session::retrieve($sessionId);
        $metadata = $session->metadata;

        $order = Order::find($metadata->order_id);

		if ($order && $metadata->payment_method === 'card' && !$order->paid_at) {
			$order->paid_at = now();
			$order->save();
		}

        return view('purchase.success');
    }
}
