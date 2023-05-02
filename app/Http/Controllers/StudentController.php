<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Math;
use App\Models\Student;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StudentController extends Controller
{
    public function index() {

        $boards = Board::all();
        $students = Student::all();
        return Inertia::render(
            'Math/Index',
            [
                //値を受け渡す
                'students' => $students,
                'boards' => $boards,
            ]
        );
        
    }

    

    public function create(Request $request) {

        $data = $request->all();
        $student = new Student;
        $student->name = $data['name'];
        $student->save();

        return response()->json($student);
        
    }

    public function delete($id) {

        // データを削除
        Student::find($id)->delete();

        // 削除されたデータのidをレスポンスとして返す
        return response()->json(['id' => $id]);
        
    }

    public function show($id) {

        $maths = Math::all();
        $student = Student::find($id);
        return Inertia::render(
            'Math/Show',
            [
                //値を受け渡す
                'student' => $student,
                'maths' => $maths,
            ]
        );
        
    }

    public function score(Request $request) {

        $student = $request->all();
        $id = $student['id'];
        $student = Student::find($id);
        $student->score = $student->score + 1;
        $student->save();

        return response()->json($student);
        
        
    }
}
