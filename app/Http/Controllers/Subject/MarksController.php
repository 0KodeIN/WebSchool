<?php

namespace App\Http\Controllers\Subject;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarksController extends Controller
{
    public function updateMark(Request $request)
    {
        $id_mark = $request->input('id_mark');
        $mark = $request->input('mark');
        if(stristr($id_mark, ',', true)){
            $date = stristr($id_mark, ',', true);
            $str = explode(",", $id_mark);
            // echo $str[0] . " " . $str[1];
            // echo $str[0] . " " . $str[1];
            $student_id = DB::table('students')
            ->select('student_id', 'id_class')
            ->where('student_surname', '=', $str[1])
            ->get();           
            $lesson_id = DB::table('lesson')
            ->select('id_lesson')
            ->where('date_visit', '=', $str[0])
            ->where('id_class', '=', $student_id[0]->id_class)
            ->get();
            // $visit = DB::table('visit')
            // ->select('*')
            // ->where('date_visit', '=', $str[0])
            // ->where('student_id', '=', $student_id[0]->student_id)
            // ->get();
                                   
            // DB::table('visit')->insert([
            //     'visit' => 'П',
            //     'student_id' => $student_id[0]->student_id,
            //     'id_lesson' => $lesson_id[0]->id_lesson,
            // ]);
            $id_visit = DB::table('visit')
            ->join('lesson', 'lesson.id_lesson', '=', 'visit.id_lesson')
            ->select('id_visit')
            ->where('student_id', '=',$student_id[0]->student_id)
            ->where('lesson.id_lesson', '=', $lesson_id[0]->id_lesson)
            ->get();
            DB::table('marks')->insert([
                'mark' => $mark,
                'id_visit' => $id_visit[0]->id_visit,
                'mark_type' => 'у/р'
            ]);
            $response = $id_visit[0]->id_visit;
            return $response;

        }
        
        
        if($mark != null){
            $response = DB::table('marks')
            ->where('id_mark', $id_mark)
            ->update(['mark' => $mark]);
            return $response;
        }
        if($mark == null){
            $response = DB::table('marks')->where('id_mark', '=', $id_mark)->delete();
            return $response;
        }
    }
    public function setLesson(Request $request){
        $date = $request->input('date_visit');
        $homework = $request->input('homework');
        $subject = $request->input('subject_name');
        $group = $request->input('group');
        $subject_id = DB::table('subjects')
        ->select('id_subject')
        ->where('subject_name', '=', $subject)        
        ->get();
        $class_id = DB::table('class')
        ->select('id_class')
        ->where('group', '=', $group[0]) 
        ->where('symbol', '=', 'б')        
        ->get();
        $lesson = DB::table('lesson')->insert([
            'date_visit' => $date,
            'id_subject' => $subject_id[0]->id_subject,
            'id_class' => $class_id[0]->id_class
        ]);
        return $lesson;
    }
    public function detailMark(Request $request){
        $date = $request->input('date_visit');
        $surname = $request->input('surname');
        $subject = $request->input('subject');
        $marks = DB::table('lesson')
        ->join('visit', 'visit.id_lesson', '=', 'lesson.id_lesson')
        ->join('marks', 'marks.id_visit', '=', 'visit.id_visit')
        ->join('subjects', 'subjects.id_subject', '=', 'lesson.id_subject')
        ->join('students', 'visit.student_id', '=', 'students.student_id')
        ->select('students.student_surname','marks.mark_type','marks.mark','lesson.homework','lesson.date_visit', 'visit.visit')
        ->where('lesson.date_visit', '=', $date) 
        ->where('students.student_surname', '=', $surname)
        ->where('subjects.subject_name', '=', $subject)         
        ->get();
        return $marks;
    }
    public function updateVisit(Request $request)
    {
        $id_visit = $request->input('id_visit');
        $visit = $request->input('visit');
        if(stristr($id_visit, ',', true)){
            $date = stristr($id_visit, ',', true);
            $str = explode(",", $id_visit);
            // echo $str[0] . " " . $str[1];
            // echo $str[0] . " " . $str[1];
            $student_id = DB::table('students')
            ->select('student_id', 'id_class')
            ->where('student_surname', '=', $str[1])
            ->get();           
            $lesson_id = DB::table('lesson')
            ->select('id_lesson')
            ->where('date_visit', '=', $str[0])
            ->where('id_class', '=', $student_id[0]->id_class)
            ->get();
            
                                   
            $newVisit = DB::table('visit')->insert([
                'visit' => $visit,
                'student_id' => $student_id[0]->student_id,
                'id_lesson' => $lesson_id[0]->id_lesson,
            ]);
    
            // $response = $id_visit[0]->id_visit;
            return $newVisit;

        }
        else{
            $response = DB::table('visit')
            ->where('id_visit', $id_visit)
            ->update(['visit' => $visit]);
            return $response;
        }

    }
    public function updateMarkType(Request $request)
    {
        $id_mark = $request->input('id_mark');
        $mark_type = $request->input('mark_type');
        $str = explode("Б", $id_mark);
        $response = DB::table('marks')
        ->where('id_mark', $str)
        ->update(['mark_type' => $mark_type]);
        return $response;
        

    }
}
