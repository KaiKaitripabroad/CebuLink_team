<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Storage;
use Termwind\Components\Li;

class UserController extends Controller
{
    // app/Http/Controllers/UserController.php

    public function mypage()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user(); // Auth::user() はログインしていれば必ずUserオブジェクトを返すのでシンプル

        // ユーザーのプロフィールを取得。存在しない場合は、空の新しいプロフィールモデルを作成
        $profile = $user->profile()->firstOrNew([]); // [] を渡すのが一般的

        // これで、$profileがnullになることはありません
        return view('users.mypage', compact('user', 'profile'));
    }

    // 引数から User $user を削除
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user(); // ログインユーザーを取得するのは正しい

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => [
                'required',
                'string',
                'max:50',
                'alpha_dash', // 英数字とアンダースコア、ハイフンのみ許可
                // 自分自身のusernameはユニークチェックから除外する
                'unique:users,username,' . $user->id
            ],
            'bio' => 'nullable|string|max:1000',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // ユーザー情報更新
        $user->name = $validated['name'];
        // usernameも更新する場合
        $user->username = $validated['username'];
        $user->save();

        // プロフィール情報更新
        $profile = $user->profile()->firstOrNew([]);
        // $profile->user_id = $user->id; // firstOrNew()が自動で設定するので、この行は不要

        $profile->bio = $validated['bio'] ?? null;

        if ($request->hasFile('profile_image')) {
            if ($profile->profile_image_url) {
                $oldPath = str_replace(Storage::url(''), 'public/', $profile->profile_image_url);
                Storage::delete($oldPath);
            }
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $profile->profile_image_url = Storage::url($path);
        }

        $profile->save();

        return response()->json([
            'message' => 'プロフィールを更新しました！',
            'profile_image_url' => $profile->profile_image_url, // JS側で画像更新に使える
        ]);
    }
}
