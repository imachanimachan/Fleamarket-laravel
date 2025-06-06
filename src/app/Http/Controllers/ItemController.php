<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;




class ItemController extends Controller
{

    public function index(Request $request)
    {
        $tab = $request->query('tab');


        if ($tab === 'mylist') {
            /** @var \App\Models\User $user */
            $user = Auth::user();

            if ($user) {
                $items = $user->likedItems()->get();
            } else {
                $items = collect();
            }

        } else {
            $items = Item::select('id','image_path', 'name')->get();
        }

        return view('item.index', compact('items'));
    }

    public function show(Request $request)
    {
        // 商品取得
        $item = Item::with(['categories', 'comments.user', 'status'])
            ->withCount(['likes', 'comments'])
            ->find($request->id);

        // ログイン済みなら「いいね」済みかどうか判定
        $liked = false;
        if(Auth::check()){
            $liked = Like::where('item_id', $item->id)->where('user_id', Auth::id())->exists();
        }

        return view('item.show', compact('item', 'liked'));
    }

    public function toggleLike(Request $request)
    {
        if(!Auth::check()){
            return redirect()->route('login');
        }

        //いいね処理
        $userId = Auth::id();
                $like = Like::where('item_id', $request->id)->where('user_id', $userId)->first();

                if ($like) {
                    $like->delete();
                } else {
                    Like::create([
                        'item_id' => $request->id,
                        'user_id' => $userId,
                    ]);
                }

            return redirect()->back();
    }

    public function comment(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $commentData = $request->only('comment', 'item_id');
        $commentData['user_id'] = $user->id;

        Comment::create($commentData);

        return redirect()->back();
    }
}
