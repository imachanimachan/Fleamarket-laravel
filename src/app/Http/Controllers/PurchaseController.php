<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\AddressRequest;

class PurchaseController extends Controller
{

    public function purchase(Request $request)
    {
        $item = Item::find($request->id);
        $user = Auth::user();
        $payment_method = $request->payment_method;

        return view('purchase.confirm', compact('item','payment_method','user'));
    }

    public function index($id, Request $request)
    {
        $item = Item::find($id);
        return view('purchase.edit', compact('item'));
    }

    public function update($id, AddressRequest $request)
    {
        $user = Auth::user();
        $form = $request->all();

        User::find($user->id)->update($form);

        $user = User::find($user->id);
        $item = Item::find($id);
        $payment_method = $request->payment_method;

        return view('purchase.confirm', compact('item', 'payment_method', 'user'));
    }

    public function create(PurchaseRequest $request)
    {
        $paymentMethodMap = [
            'convenience' => 1,
            'card' => 2,
        ];

        $paymentMethodKey = $request->input('payment_method');
        $paymentMethodId = $paymentMethodMap[$paymentMethodKey] ?? null;

        $user = Auth::user();

        Order::create([
            'item_id' => $request->input('item_id'),
            'user_id' => $user->id,
            'payment_method_id' => $paymentMethodId,
        ]);

        return redirect()->route('item.purchase', ['id' => $request->input('item_id'), 'payment_method' => $paymentMethodKey])
            ->with('message', '商品を購入しました');
    }
}