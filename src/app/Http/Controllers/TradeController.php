<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Message;
use App\Http\Requests\ChatMessageRequest;

class TradeController extends Controller
{
    public function index(Request $request, $id)
    {
        $user = Auth::user();

        if ($request->has('draft') && $request->has('from_item_id')) {

            if ($request->draft === '') {
                session()->forget('trade_draft.' . $request->from_item_id);
            } else {
                session([
                    'trade_draft.' . $request->from_item_id => $request->draft,
                ]);
            }
        }

        $draftBody = session("trade_draft.$id");

        $tradeItems = Item::with([
            'order.user',
            'user',
        ])
            ->where(function ($q) use ($user) {
                $q->whereHas('order', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                })
                    ->orWhere(function ($q) use ($user) {
                        $q->where('user_id', $user->id)
                            ->whereHas('order');
                    });
            })
            ->withMax('messages', 'created_at')
            ->orderByDesc('messages_max_created_at')
            ->get();

        $currentItem = Item::with([
            'order.user',
            'user',
            'messages.user',
        ])
            ->where('id', $id)
            ->where(function ($q) use ($user) {
                $q->whereHas('order', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                })
                    ->orWhere(function ($q) use ($user) {
                        $q->where('user_id', $user->id)
                            ->whereHas('order');
                    });
            })
            ->firstOrFail();

        Message::where('item_id', $currentItem->id)
            ->where('user_id', '!=', $user->id)
            ->whereNull('read_at')
            ->update([
                'read_at' => now(),
            ]);

        if ($currentItem->user_id === $user->id) {
            $tradeUser = $currentItem->order->user;
        } else {
            $tradeUser = $currentItem->user;
        }

        $messages = $currentItem->messages
            ->sortBy('created_at');

        return view('trade.index', compact(
            'tradeItems',
            'currentItem',
            'user',
            'tradeUser',
            'messages',
            'draftBody'
        ));
    }

    public function store(ChatMessageRequest $request, $id)
    {
        $user = Auth::user();

        $item = Item::findOrFail($id);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')
                ->store('messages', 'public');
        }

        Message::create([
            'item_id' => $item->id,
            'user_id' => $user->id,
            'body' => $request->body,
            'image_path' => $imagePath,
        ]);

        session()->forget('trade_draft.' . $id);

        return redirect()->route('trade.index', ['id' => $item->id]);
    }
    public function destroy(Message $message)
    {
        abort_unless($message->user_id === auth()->id(), 403);

        $message->delete();

        return back();
    }

    public function edit(Message $message)
    {
        abort_unless($message->user_id === auth()->id(), 403);

        return view('trade.edit', compact('message'));
    }

    public function update(Request $request, Message $message)
    {
        abort_unless($message->user_id === auth()->id(), 403);

        $request->validate([
            'body' => 'required|max:400',
        ]);

        $message->update([
            'body' => $request->body,
        ]);

        return redirect()->route('trade.index', $message->item_id);
    }
}

