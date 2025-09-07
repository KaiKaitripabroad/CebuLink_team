<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;

class UserController extends Controller
{
    public function mypage()
    {
        // usersテーブルからユーザー情報を取得
        $user = User::findOrFail(Auth::id());

        // profilesテーブルから関連するプロフィール情報を取得
        // profilesテーブルのuser_idはusers.idと1対1で紐づいているため、このように取得できます。
        $profile = $user->profile;

        $profile = $user->profile()->firstOrNew();
        $profile = Profile::where('user_id', $user->id)->first();

        return view('users.mypage', compact('user', 'profile'));
    }
    public function updateBio(Request $request)
    {

        $user = Auth::user();
        if ($user) {
            // プロフィールのbioカラムを更新
            $user->profile()->update(['bio' => $request->bio]);
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 401); // 401 Unauthorized
    }
}
