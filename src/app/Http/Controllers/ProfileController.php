<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();

        return view('mypage.edit', compact('user'));
    }

    public function update(ProfileRequest $request)
    {
        $user = Auth::user();
        $form = $request->all();

        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->store('users', 'public');
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

        $tab = $request->query('tab', 'sell');

        $tradeCount = Item::whereHas('order', function ($q) use ($user) {
            $q->where('user_id', $user->id)
                ->where('buyer_completed', false); // 購入者として未完了
        })
            ->orWhere(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                    ->whereHas('order', function ($q2) use ($user) {
                        $q2->where('seller_completed', false); // 出品者として未完了
                    });
            })
            ->count();


        if ($tab === 'buy') {
            $items = $user->orders()->with('item')->get()->pluck('item');

        } elseif ($tab === 'trade') {

            $items = Item::whereHas('order', function ($q) use ($user) {
                // 購入者なら buyer_completed = false
                // 出品者なら seller_completed = false
                $q->where(function ($q2) use ($user) {
                    $q2->where('user_id', $user->id)
                        ->where('buyer_completed', false)
                        ->orWhere(function ($q3) use ($user) {
                            $q3->whereHas('item', function ($q4) use ($user) {
                                $q4->where('user_id', $user->id);
                            })
                                ->where('seller_completed', false);
                        });
                });
            })
                ->withCount([
                    'messages as notify_count' => function ($q) use ($user) {
                        $q->where('user_id', '!=', $user->id)
                            ->whereNull('read_at');
                    }
                ])
                ->get();

        } else {

            $items = $user->items;
        }
        return view('mypage.index', compact('user', 'items', 'tradeCount'));
    }
}
