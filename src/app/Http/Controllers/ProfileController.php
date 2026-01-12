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

        $averageRating = $user->averageRating();

        $tab = $request->query('tab', 'sell');

        $tradeItems = Item::whereHas('order', function ($q) use ($user) {
            $q->where(function ($q2) use ($user) {

                $q2->where(function ($q3) use ($user) {
                    $q3->where('user_id', $user->id)
                        ->where('buyer_completed', false);
                })
                    ->orWhereHas('item', function ($q4) use ($user) {
                        $q4->where('user_id', $user->id);
                    });
            });
        })

            ->withCount([
                'messages as notify_count' => function ($q) use ($user) {
                    $q->where('user_id', '!=', $user->id)
                        ->whereNull('read_at');
                }
            ])
            ->withMax('messages', 'created_at')
            ->orderByDesc('messages_max_created_at')
            ->get();

        $notificationTotal = $tradeItems->sum('notify_count');


        if ($tab === 'buy') {
            $items = $user->orders()->with('item')->get()->pluck('item');

        } elseif ($tab === 'trade') {

            $items = $tradeItems;
        } else {

            $items = $user->items;
        }
        return view('mypage.index', compact('user', 'items', 'averageRating', 'notificationTotal'));
    }
}
