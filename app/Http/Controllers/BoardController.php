<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Board;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;


class BoardController extends Controller
{
    public function index()
    {
        $boards = Board::all();
        return Inertia::render(
            'Board/Index',
            [
                //値を受け渡す
                'boards' => $boards,
            ]
        );
    }
    
    public function saveData(Request $request)
    { //完成
        // Vue.jsから送信されたデータを取得
        $data = $request->all();

        //  現在認証しているユーザー取得
        $user = Auth::user();

        // モデルを介してデータベースに保存
        $board = new Board;
        $board->user_id = $user->id;
        $board->title = $data['title'];
        $board->content = $data['content'];
        $board->likes = 0;
        $board->save();

        return response()->json($board);
    }

    public function deleteData($id)
    { //完成
        // データを削除
        Board::find($id)->delete();

        // 削除されたデータのidをレスポンスとして返す
        return response()->json(['id' => $id]);
    }

    public function update(Request $request, $id)
    {
        // Vue.jsから送信されたデータを取得
    $data = $request->all();

    // データベースから該当の掲示板データを取得
    $board = Board::findOrFail($id);

    // データを更新
    $board->title = $data['title'];
    $board->content = $data['content'];
    $board->save();

    return response()->json($board);
    }

    public function like($id)
    {
    // いいねをする処理
    $board = Board::findOrFail($id); // 投稿を取得
    $board->likes++; // いいね数をインクリメント
    $board->save(); // いいね数を保存

    // 成功時のレスポンスを返す
    return response()->json(['message' => 'いいねしました。', 'likes' => $board->likes]);
    }
}
