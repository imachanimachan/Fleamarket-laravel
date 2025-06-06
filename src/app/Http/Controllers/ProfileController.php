<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('mypage.edit');
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $form = $request->all();

        if($request->hasFile('image_path')){
            $path = $request->file('image_path')->store('users','public');
        }

        $form['image_path'] = $path;

        unset($form['_token'], $form['_method']);

        User::find($user->id)->update($form);

        return redirect('/');
    }

    public function index()
    {
        $user = Auth::user();

        //ここに出品した商品と購入した商品を取ってくる処理を書く//

        return view('mypage.index',compact('user'));
    }
}
