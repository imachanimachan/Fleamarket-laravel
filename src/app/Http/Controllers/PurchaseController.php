<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
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
}