<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class PurchaseController extends Controller
{

    public function purchase(Request $request)
    {
        $item = Item::find($request->id);

        return view('purchase.confirm');
    }
}
