<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
class SearchController extends Controller
{
    public function contextSearch(Request $request){
        // if($request->input('user') == 'student'){
            $search = $request->input('search') . "%";
            $students = DB::table('students')
                ->whereRaw("student_name like '$search'")
                ->get();
            return $students;
        // }
    }
    public function searchBySubject(Request $request){
        // if($request->input('user') == 'student'){
            $search = $request->input('subject');
            $teachers = DB::table('teacher_subjects')
            ->join('subjects', 'teacher_subjects.id_subject', '=', 'subjects.id_subject')
            ->join('teachers', 'teachers.id_teacher', '=', 'teacher_subjects.id_teacher')
            ->select('teachers.teacher_name', 'teachers.teacher_surname', 'teachers.id_teacher')
            ->where('subjects.subject_name', '=', $search)
            ->get();
            return $teachers;
        // }
    }
}
