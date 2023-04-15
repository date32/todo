<?php

namespace App\Http\Controllers;

use App\Http\Requests\todoStoreRequest;
use App\Models\todo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class todoController extends Controller
{
    public function index() {
        // ログイン者のデータ取得
        $user = Auth::user();

        // ログイン者のidからログイン者のtodoを全て取得 
        $todos = todo::where('users_id', $user->id)->get();
        return view('todo.index', ['user' => $user, 'todos' => $todos]);
    }

    public function store(todoStoreRequest $request) {
        // ログイン者のデータ取得
        $user = Auth::user();
        
        // 新しいtodoモデル作成　ログイン者のid,フォームのtodo,todoはまだ終わってないのでfalse これらを保存
        $todo = new todo;
        $todo->users_id = $user->id;
        $todo->todo = $request->todo;
        $todo->comp_flag = false;
        $todo->save();
        return redirect()->route('index');
    }

    public function finish(Request $request) {
        // ログイン者のデータ取得
        $user = Auth::user();

        // フォームからのtodoのidにより、完了したtodoを取得
        $todo = todo::where('id', $request->todo_id)->first();

        // 完了はtrueにする　そして保存
        $todo->comp_flag = true;
        $todo->save();
        return redirect()->route('index');
    }

    public function edit(Request $request) {
        // ログイン者のデータ取得
        $user = Auth::user();

        // フォームからのtodoのidにより、変更したいtodoを取得
        $todo = todo::where('id', $request->todo_id)->first();
        return view('todo.edit', ['user' => $user, 'todo' => $todo]);
    }

    public function update(todoStoreRequest $request) {
        // ログイン者のデータ取得
        $user = Auth::user();

        // フォームからのtodoのidにより、変更したいtodo及び変更内容をフォームから取得　そして、保存
        $todo = todo::where('id', $request->todo_id)->first();
        $todo->todo = $request->todo;
        $todo->save();
        return redirect()->route('index');
    }

    public function delete(Request $request) {
        // ログイン者のデータ取得
        $user = Auth::user();

        // フォームからのtodoのidにより、削除したいtodoを取得　そして、削除
        $todo = todo::where('id', $request->todo_id)->first();
        $todo->delete();
        return redirect()->route('index');
    }

    public function error() {
        // ログイン者のデータ取得
        $user = Auth::user();

        return view('todo.error', ['user' =>$user]);
    }

    // 画像を登録する
    public function upload(Request $request)
    {
        // ログイン者のデータ取得
        $user = Auth::user();

        // ユーザーデータ取得
        $u = User::find($user->id);

        // ディレクトリ名
        $dir = 'img';

        // ファイル名変更
        $file_name = $user->id;
        $file_name = $file_name . '.jpg';
        
        // ファイルを保存　storageというフォルダに保存される（'image'はフォームからのキー）
        // storeAsはディレクトリ名とファイル名を指定して保存する
        $request->file('image')->storeAs('public/' . $dir, $file_name);

        // DBに保存
        $u->img = 'storage/' . $dir . '/' . $file_name;
        $u->save();

        return redirect()->route('index');
        // ターミナルで　php artisan storage:link　これを実行しないとstorageを参照しない
    }

    public function show(Request $request) {
        // ログイン者のデータ取得
        $user = Auth::user();

        // ログイン者のidからログイン者のtodoを全て取得
        $todos = todo::where('users_id', $user->id)->get();
        return view('todo.show', ['user' => $user, 'todos' => $todos]);
    }

    public function start(Request $request) {
        // ログイン者のデータ取得
        $user = Auth::user();

        // フォームからのtodoのidにより、元に戻すしたいtodo取得　そして、保存
        $todo = todo::where('id', $request->todo_id)->first();
        $todo->comp_flag = false;
        $todo->save();
        return redirect()->route('index');
    }
}
