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
            $table->foreignId('organizer_id')->constrained('users')->onDelete('cascade'); // 主催者ユーザーID
            $table->string('title'); // イベントタイトル
            $table->text('description')->nullable(); // イベント詳細
            $table->string('location')->nullable(); // 場所
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
