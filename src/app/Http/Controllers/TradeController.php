<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TradeController extends Controller
{
    public function index()
    {
        return view('trade.index');
    }
}
