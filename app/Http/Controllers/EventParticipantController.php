<?php

namespace App\Http\Controllers;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EventParticipantController extends Controller
{
    // イベントに参加する処理
    public function join(Event $event)
    {
        // attachメソッドで中間テーブルにレコードを追加
        Auth::user()->joinedEvents()->attach($event->id);

        return response()->json([
            'success' => true,
            'participant_count' => $event->participants()->count()
        ]);
    }

    // 参加をキャンセルする処理
    public function cancel(Event $event)
    {
        // detachメソッドで中間テーブルからレコードを削除
        Auth::user()->joinedEvents()->detach($event->id);

        return response()->json([
            'success' => true,
            'participant_count' => $event->participants()->count()
        ]);
    }
}
