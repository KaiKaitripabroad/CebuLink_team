<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Carbon\Carbon;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function guest_index()
    {
        return view('events.guest_index');
    }
    public function index()
    {
        // DBのeventsテーブルから全件取得（新しい順に並べる）
        $events = Event::latest()->get();

        // events.blade.php に渡す
        return view('events.index', compact('events'));
    }
    public function detail($id)
    {
        $event = Event::findOrFail($id);
        return view('events.detail', compact('event'));
    }
    public function detail_guest($id)
    {
        return view('events.detail_guest');
    }
    // ★ここに追加
    public function store(Request $request)
    {
        $request->validate([
            'title'      => 'required|string|max:255',
            'date'       => 'required|date',
            'start_time' => 'required',
            'end_time'   => 'required',
            'img_url'        => 'nullable|image|max:5120', // ← img_url ではなく img に
            'latitude'   => 'nullable|numeric',
            'longitude'  => 'nullable|numeric',
        ]);

        $event = new Event();
        $event->title = $request->title;
        $event->text  = $request->text;
        $event->date  = $request->date;
        $event->start_at = $request->date . ' ' . $request->start_time . ':00';
        $event->end_at   = $request->date . ' ' . $request->end_time . ':00';
        $event->user_id = Auth::id();
        $event->latitude = $request->latitude;
        $event->longitude = $request->longitude;

        // ファイルがアップロードされていたらstorageに保存
        if ($request->hasFile('img_url')) {
            $path = $request->file('img_url')->store('events', 'public');
            $event->img_url = $path; // storage/ はつけず保存
        }
        $event->save();


        return redirect()->route('events.index')->with('success', 'イベントを作成しました！');
    }
    public function filterByDate(Request $request)
    {
        // 'date'というパラメータが送られてきた場合
        if ($request->has('date')) {
            $selectedDate = $request->input('date');

            // 'start_date'カラム（実際のカラム名に合わせてください）の日付が一致するイベントを取得
            $events = Event::whereDate('start_at', '<=', $selectedDate)
                ->whereDate('end_at', '>=', $selectedDate)
                ->latest()
                ->get();
        } else {
            // 'date'パラメータがない場合（「ALL」表示用）は、全てのイベントを取得
            $events = Event::latest()->get();
        }

        // イベントリストの部分だけをレンダリングするBladeビューを返す
        return view('events.partials.event-list', compact('events'));
    }
}
