<?php

namespace App\Http\Controllers;

use App\Models\Math;
use App\Models\Student;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MathController extends Controller
{
    public function edit() {
        
        $maths = Math::all();
        return Inertia::render(
            'Math/QuestionEdit',
            [
                //値を受け渡す
                'maths' => $maths
            ]
        );
    }

    public function create(Request $request) {

        $data = $request->all();
        $math = new Math();
        $math->title = $data['title'];
        $math->question = $data['question'];
        $math->answer = $data['answer'];
        $math->save();

        return response()->json($math);
        
    }

    public function delete($id) {

        Math::find($id)->delete();

        return response()->json(['id' => $id]);
        
    }

    public function update($id) {

        $math = Math::find($id);
        return Inertia::render(
            'Math/QuestionUpdate',
            [
                //値を受け渡す
                'math' => $math
            ]
        );
        
    }

    public function updateTitle(Request $request, $id) {

        $data = $request->all();
        $math = Math::find($id);
        $math->title = $data['title'];
        $math->save();
        return response()->json($math);
        
    }

    public function updateQuestion(Request $request, $id) {

        $data = $request->all();
        $math = Math::find($id);
        $math->question = $data['question'];
        $math->save();
        return response()->json($math);
        
    }

    public function updateAnswer(Request $request, $id) {

        $data = $request->all();
        $math = Math::find($id);
        $math->answer = $data['answer'];
        $math->save();
        return response()->json($math);
        
    }


    public function upload(Request $request, $id)
    {
        $math_id = Math::find($id)->id;
        // ディレクトリ名
        $dir = 'img/math';

        // ファイル名変更
        // $file_name = $request->menu_id;
        $file_name = $math_id . '.jpg';
        
        // ファイルを保存　storageというフォルダにに保存される
        $request->file('file')->storeAs('public/' . $dir, $file_name);

        // DBに保存
        $math = Math::find($id);
        $math->img = '/storage/' . $dir . '/' . $file_name;
        $math->save();

        return response()->json($math);
        // return $math->img;
    }

    public function delImg($id) {

        $math = Math::find($id);
        $math->img = null;
        $math->save();

        return response()->json($math);
        
    }

    public function img() {

        $maths = Math::all();
        return Inertia::render(
            'Math/QuestionEdit2',
            [
                //値を受け渡す
                'maths' => $maths
            ]
        );
        
    }
}
