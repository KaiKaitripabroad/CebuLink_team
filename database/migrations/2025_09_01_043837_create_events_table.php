<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('title'); // イベントタイトル
            $table->text('text')->nullable(); // イベント本文
            $table->string('img_url')->nullable(); // 画像URL
            $table->string('location')->nullable(); // 場所
            $table->date('date'); // 日付カラム
            $table->dateTime('start_at'); // 開始日時
            $table->dateTime('end_at'); // 終了日時
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
