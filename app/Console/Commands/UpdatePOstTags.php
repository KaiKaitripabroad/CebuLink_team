<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use Illuminate\Support\Str;

class UpdatePostTags extends Command
{
    protected $signature = 'posts:update-tags';
    protected $description = 'Update NULL tags in posts based on text content';

    public function handle()
    {
        $posts = Post::whereNull('tag')->get();

        foreach ($posts as $post) {
            $text = $post->text;

            // 実際の投稿内容に合わせて分類条件を追加
            if (Str::contains($text, ['ラーメン', 'カフェ', '食', 'qwerty', 'うぇｒｔｙ'])) {
                $post->tag = 'food';
            } elseif (Str::contains($text, ['ショップ', '買い物', '店', 'ｘｃｖｂ'])) {
                $post->tag = 'shop';
            } elseif (Str::contains($text, ['イベント', 'フェス', 'ライブ', 'asdfg', 'ｓｄｆｇ'])) {
                $post->tag = 'event';
            } elseif (Str::contains($text, ['ボランティア', '支援'])) {
                $post->tag = 'volunteer';
            } elseif (Str::contains($text, ['観光', '名所', '旅行'])) {
                $post->tag = 'sightseeing';
            } else {
                $post->tag = 'others';
            }

            $post->save();
        }

        $this->info('タグの更新が完了しました！');
    }
}
