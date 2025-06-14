<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Status;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ExhibitionRequest;

class SellController extends Controller
{
    public function sell()
    {
        $categories = Category::all();
        $statuses = Status::all();

        return view('sell' , compact('categories','statuses'));
    }

    public function create(ExhibitionRequest $request)
    {
        $path = $request->file('image_path')->store('items', 'public');
        $fileName = basename($path);

        $userId = Auth::id();

        $item = Item::create([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'description' => $request->input('description'),
            'image_path' => $fileName,
            'brand' => $request->input('brand'),
            'status_id' => $request->input('status_id'),
            'user_id' => $userId,
            'price' => $request->input('price')
        ]);

        $item->categories()->sync($request->input('categories'));

        return redirect()->back()->with('message','商品を出品しました');
    }
}
