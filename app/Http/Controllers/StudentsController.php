<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\DB;
use Exception;


class StudentsController extends Controller
{
    public function index()
    {
        $value = json_encode(Student::all(),JSON_UNESCAPED_UNICODE);
        return $value;

    }
    public function getUser(Request $request){
        $id = $request->input('id');
        if(count($value = Student::where('student_id', $id)
        ->get()) > 0){
            return $value;
        }
        if(count($value = Teacher::where('id_teacher', $id)
        ->get()) > 0){
            return $value;
        }

    }
    public function getStudentClass(Request $request){
        $class = $request->input('searchClass');
        $word = $request->input('searchWord');
        $users = DB::table('students')
            ->join('class', 'students.id_class', '=', 'class.id_class')
            ->join('users', 'students.student_id', '=', 'users.student_id')
            ->where('group', '=', $class)
            ->where('symbol', '=', $word)
            ->get();
        return $users;
    }
    public function getAllStudents(Request $request){
        $class = $request->input('group');
        $word = $request->input('symbol');
        $users = DB::table('students')->orderBy('students.student_surname')
            ->join('class', 'students.id_class', '=', 'class.id_class')
            ->where('group', '=', $class)
            ->where('symbol', '=', $word)
            ->select('students.student_name', 'students.student_surname')
            ->get();
        return $users;
    }
    public function create()
    {

        return 'Hey';

    }
}
