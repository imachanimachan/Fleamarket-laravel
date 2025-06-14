<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();

        return view('mypage.edit',compact('user'));
    }

    public function update(ProfileRequest $request)
    {
        $user = Auth::user();
        $form = $request->all();

        if($request->hasFile('image_path')){
            $path = $request->file('image_path')->store('users','public');
            $form['image_path'] = basename($path);
        }

        unset($form['_token'], $form['_method']);

        User::find($user->id)->update($form);

        return redirect('/');
    }

    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $tab = $request->query('tab');

        if ($tab === 'buy') {
            $items = $user->orders()->with('item')->get()->pluck('item');

        } else {
            $items= $user->items;
        }

        return view('mypage.index',compact('user','items'));
    }
}
