@forelse ($events as $event)
    <a href="{{ route('events.detail', $event->id) }}" class="event-card">
        <img src="{{ $event->img_url ? asset('storage/' . $event->img_url) : asset('images/no-image.png') }}"
            alt="イベント画像" class="event-image">
        <div class="event-info">
            <h3>{{ $event->title }}</h3>
            <p>{{ Str::limit($event->text, 50) }}</p>
        </div>
    </a>
@empty
    {{-- イベントが1件もない場合に表示するメッセージ --}}
    <p style="text-align: center; width: 100%; color: #555;">この日のイベントはありません。</p>
@endforelse
