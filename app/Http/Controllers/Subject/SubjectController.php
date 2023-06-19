<?php

namespace App\Http\Controllers\Subject;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SubjectController extends Controller
{
    public $array = [];
    public function GetAllSubjects(Request $request)
    {
        $id_student = $request->user()->student_id;
        $id_teacher = $request->user()->id_teacher;
        if($id_student != null){
            $student = DB::table('users')
            ->join('students', 'users.student_id', '=', 'students.student_id')
            ->select('*')
            ->where('students.student_id', '=', $id_student)
            ->get();
        }
        if($id_teacher != null){
            $teacher = DB::table('users')
            ->join('teachers', 'users.id_teacher', '=', 'teachers.id_teacher')
            ->select('*')
            ->where('teachers.id_teacher', '=', $id_teacher)
            ->get();
        }
        $subjects = DB::table('class')
            ->join('work_program', 'work_program.id_program', '=', 'class.id_program')
            ->join('disciplines', 'disciplines.id_program', '=', 'work_program.id_program')
            ->join('subjects', 'disciplines.id_subject', '=', 'subjects.id_subject')
            ->select('subjects.subject_name', 'subjects.id_subject')
            ->where('class.id_class', '=', 101)
            ->get();
        // $value = json_encode(Subject::all(),JSON_UNESCAPED_UNICODE);
        return $subjects;
    }
    public function GetSubjects()
    {
        $subjects = Subject::all();
        return $subjects;
    }
    
    public function GetMarks(Request $request)
    {
        $array = [];
        $username = $request->input("username");
        // $username = $request->user()->student_name;
        $id_student = $request->user()->student_id;
        // return $id_student;
        // $username = "Никита";
        $subject = $request->input("subject");
        $marks = DB::table('visit')
            ->join('marks', 'marks.id_visit', '=', 'visit.id_visit')
            ->join('lesson', 'lesson.id_lesson', '=', 'visit.id_lesson')
            ->join('subjects', 'subjects.id_subject', '=', 'lesson.id_subject')
            ->join('students', 'students.student_id', '=', 'visit.student_id')
            ->select('lesson.date_visit', 'marks.mark')
            ->where('subjects.subject_name', '=', $subject)
            ->where('students.student_id', '=',  $id_student)
            ->get();
        $str = "";
        $array[$marks[0]->date_visit] = $marks[0]->mark;
        for($i = 1; $i <count($marks); $i++){
            if($marks[$i]->date_visit == $marks[$i-1]->date_visit){
                $str =  $marks[$i-1]->mark .',' . $marks[$i]->mark;
                $array[$marks[$i]->date_visit] = $str;
                //  echo $str . " ";
            }
            else{
                $array[$marks[$i]->date_visit] = $marks[$i]->mark;
            }
        }
        $value = json_encode($array,JSON_UNESCAPED_UNICODE);
        return $value;
    }
    public function DateMarks(Request $request)
    {
        $array = [];
        $username = $request->input("username");
        $student_id = $request->user()->student_id;
        // $username = "Никита";
        $subject = $request->input("subject");
        $start_date = $request->input("start_date");
        $end_date = $request->input("end_date");
        $year = $request->input("year");
        $toYear = $year + 1;
        $quarter = $request->input("quarter");
        if($quarter == 1){
            $start_date = $year. '-'. '09-01';
            $end_date = $year. '-'. '11-11'; 
        }
        if($quarter == 2){
            $start_date = $year. '-'. '11-11';
            $end_date = $toYear. '-'. '01-13'; 
        }
        if($quarter == 3){
            $start_date = $toYear. '-'. '01-13';
            $end_date = $toYear. '-'. '04-03'; 
        }
        if($quarter == 3){
            $start_date = $toYear. '-'. '04-03';
            $end_date = $toYear. '-'. '06-01'; 
        }
        $marks = DB::table('visit')
            ->join('marks', 'marks.id_visit', '=', 'visit.id_visit')
            ->join('lesson', 'lesson.id_lesson', '=', 'visit.id_lesson')
            ->join('subjects', 'subjects.id_subject', '=', 'lesson.id_subject')
            ->join('students', 'students.student_id', '=', 'visit.student_id')
            ->select('lesson.date_visit', 'marks.mark')
            ->where('subjects.subject_name', '=', $subject)
            // ->where('students.student_name', '=',  $username)
            ->where('students.student_id', '=',  $student_id)
            ->where('lesson.date_visit', '>=', $start_date)
            ->where('lesson.date_visit', '<=', $end_date)
            ->get();
        $str = "";
        $array[$marks[0]->date_visit] = $marks[0]->mark;
        for($i = 1; $i <count($marks); $i++){
            if($marks[$i]->date_visit == $marks[$i-1]->date_visit){
                $str =  $marks[$i-1]->mark .',' . $marks[$i]->mark;
                $array[$marks[$i]->date_visit] = $str;
                //  echo $str . " ";
            }
            else{
                $array[$marks[$i]->date_visit] = $marks[$i]->mark;
            }
        }
        $value = json_encode($array,JSON_UNESCAPED_UNICODE);
        return $value;
    }
    public function GetWeightMark(Request $request)
    {
        $array = [];
        $arr = [];
        $username = $request->input("username");
        // $username = "Никита";
        $subject = $request->input("subject");
        $marks = DB::table('visit')
            ->join('marks', 'marks.id_visit', '=', 'visit.id_visit')
            ->join('lesson', 'lesson.id_lesson', '=', 'visit.id_lesson')
            ->join('subjects', 'subjects.id_subject', '=', 'lesson.id_subject')
            ->join('students', 'students.student_id', '=', 'visit.student_id')
            ->select('marks.mark_type', 'marks.mark')
            ->where('subjects.subject_name', '=', $subject)
            ->where('students.student_name', '=',  $username)
            ->get();
           
        // $str = "";

        $value = json_encode($marks,JSON_UNESCAPED_UNICODE);
        return $value;
    }
    public function GetDashboardWeight(Request $request)
    {
        $array = [];
        $arr = [];
        $group = $request->input("group");
        $symbol = $request->input("symbol");
        $subject = $request->input("subject");
        $marks = DB::table('visit')->orderBy('students.student_surname')
            ->join('marks', 'marks.id_visit', '=', 'visit.id_visit')
            ->join('lesson', 'lesson.id_lesson', '=', 'visit.id_lesson')
            ->join('subjects', 'subjects.id_subject', '=', 'lesson.id_subject')
            ->join('students', 'students.student_id', '=', 'visit.student_id')
            ->join('class', 'students.id_class', '=', 'class.id_class')
            ->select('marks.mark_type', 'marks.mark', 'students.student_name', 'students.student_surname',)
            ->where('subjects.subject_name', '=', $subject)
            ->where('class.group', '=',  $group)
            ->where('class.symbol', '=',  $symbol)
            ->get();
            $str =  $marks[0]->student_name . " " . $marks[0]->student_surname;
            if($marks[0]->mark_type == 'у/р'){
                $marks[0]->mark_type = 1;
            }
            if($marks[0]->mark_type == 'к/р'){
                $marks[0]->mark_type = 10;
            }
            $mark = $marks[0]->mark . " " . $marks[0]->mark_type;
            // echo $mark . " ";
            array_push($arr,$mark);
            $array[$str] = $arr;
            // print_r($array[$str]);
            
            // array_push($array[$str], $arr);               
            // $array[$str] = array_push($arr, $marks[0]->mark);
            for($i = 1; $i <count($marks); $i++){
                if($marks[$i]->mark_type == 'у/р'){
                    $marks[$i]->mark_type = 1;
                }
                if($marks[$i]->mark_type == 'к/р'){
                    $marks[$i]->mark_type = 10;
                }
                if($marks[$i]->student_surname != $marks[$i-1]->student_surname){
                    $arr = [];
                } 
                $str =  $marks[$i]->student_name . " " . $marks[$i]->student_surname;
                $mark = $marks[$i]->mark . " " . $marks[$i]->mark_type;
               
                array_push($arr, $mark);
                $array[$str] = $arr;
                // print_r($array[$str]);
             
                // $array[$str] = array_push($arr, $marks[$i]->mark);            
            }
            $value = json_encode($array,JSON_UNESCAPED_UNICODE);
            return $value;
        return $marks;
    }
    public function GetAvgMark(Request $request)
    {
        $array = [];
        $arr = [];
        $group = $request->input("group");
        $symbol = $request->input("symbol");
        $subject = $request->input("subject");
        $marks = DB::table('visit')->orderBy('students.student_surname')
            ->join('marks', 'marks.id_visit', '=', 'visit.id_visit')
            ->join('lesson', 'lesson.id_lesson', '=', 'visit.id_lesson')
            ->join('subjects', 'subjects.id_subject', '=', 'lesson.id_subject')
            ->join('students', 'students.student_id', '=', 'visit.student_id')
            ->join('class', 'students.id_class', '=', 'class.id_class')
            ->select('marks.mark_type', 'marks.mark', 'students.student_name', 'students.student_surname',)
            ->where('subjects.subject_name', '=', $subject)
            ->where('class.group', '=',  $group)
            ->where('class.symbol', '=',  $symbol)
            ->get();
        // $str = "";
        $str =  $marks[0]->student_name . " " . $marks[0]->student_surname;
        array_push($arr, $marks[0]->mark);
        $array[$str] = $arr;
        // array_push($array[$str], $arr);               
        $array[$str] = array_push($arr, $marks[0]->mark);
        for($i = 1; $i <count($marks); $i++){
            if($marks[$i]->student_surname != $marks[$i-1]->student_surname){
                $arr = [];
            } 
            $str =  $marks[$i]->student_name . " " . $marks[$i]->student_surname;
            array_push($arr, $marks[$i]->mark);
            $array[$str] = $arr;               
            // $array[$str] = array_push($arr, $marks[$i]->mark);            
        }
        $value = json_encode($array,JSON_UNESCAPED_UNICODE);
        return $value;
    }
    public function GetTeacherRating(Request $request)
    {
        $array = [];
        $arr = [];
        $teachers = DB::table('teachers')
            ->select('teacher_surname', 'teacher_name', 'id_teacher')
            ->get();
        
        for($i = 0; $i < count($teachers); $i++){
            $subjects = DB::table('teachers')
            ->join('teacher_subjects', 'teachers.id_teacher', '=', 'teacher_subjects.id_teacher')
            ->join('subjects', 'subjects.id_subject', '=', 'teacher_subjects.id_subject')
            ->select('subjects.subject_name')
            ->where('teachers.id_teacher', '=',  $teachers[$i]->id_teacher)
            ->get();

            $timetable = DB::table('timetable')
            ->select('tid_timetable')
            ->where('id_teacher', '=',  $teachers[$i]->id_teacher)
            ->get();
            if(count($timetable) == 0){
                $posts[$i] = array(
                    'chet1'=> 0, 
                    'chet2'=> 0,
                    'rating' => 0,
                    'surname' => $teachers[$i]->teacher_surname,
                    'name' => $teachers[$i]->teacher_name,
                    'subject' => $subjects[0]->subject_name
                    
                );
                continue;
            }
            // $subjects[0]->subject_name
            if($teachers[$i]->teacher_surname == 'Комогорова') $subjects[0]->subject_name = 'Алгебра';            
            $marks = DB::table('marks')           
            ->join('visit', 'visit.id_visit', '=', 'marks.id_visit')
            ->join('lesson', 'lesson.id_lesson', '=', 'visit.id_lesson')
            ->join('class', 'class.id_class', '=', 'lesson.id_class')
            ->join('subjects', 'subjects.id_subject', '=', 'lesson.id_subject')
            ->join('timetable', 'timetable.id_class', '=', 'class.id_class')
            ->join('teachers', 'teachers.id_teacher', '=', 'timetable.id_teacher')
            ->select('marks.mark')
            ->where('subjects.subject_name', '=', $subjects[0]->subject_name)
            ->where('class.group', '=', 7)
            ->where('class.symbol', '=', 'б')
            ->where('lesson.date_visit', '<', '2022-10-30')
            // ->where('timetable.tid_timetable', '=',  $timetable[0]->tid_timetable)
            ->get();
            
            $sum = 0;
            if(count($marks)>0){
                for($j = 0; $j < count($marks); $j++){
                    $sum += $marks[$j]->mark;
                }
                $avg1 = $sum / count($marks);
 
            }
            
            else{
                $avg1 = 4 + lcg_value();
            }
           
            $sum = 0;
            $marks_2 = DB::table('marks')           
            ->join('visit', 'visit.id_visit', '=', 'marks.id_visit')
            ->join('lesson', 'lesson.id_lesson', '=', 'visit.id_lesson')
            ->join('class', 'class.id_class', '=', 'lesson.id_class')
            ->join('subjects', 'subjects.id_subject', '=', 'lesson.id_subject')
            ->join('timetable', 'timetable.id_class', '=', 'class.id_class')
            ->join('teachers', 'teachers.id_teacher', '=', 'timetable.id_teacher')
            ->select('marks.mark')
            ->where('subjects.subject_name', '=', $subjects[0]->subject_name)
            ->where('class.group', '=', 7)
            ->where('class.symbol', '=', 'б')
            ->where('lesson.date_visit', '>', '2022-10-30')
            ->where('timetable.tid_timetable', '=',  $timetable[0]->tid_timetable)
            ->get();
            if(count($marks_2)>0){
                for($j = 0; $j < count($marks_2); $j++){
                    $sum += $marks_2[$j]->mark;
                }
                $avg2 = $sum / count($marks_2);
 
            }
            else{
                $avg2 = 4 + lcg_value();
            }
            
            $rat = 0;
            if($avg2 > $avg1) $rat = 1;
            $posts[$i] = array(
                'chet1'=> $avg1, 
                'chet2'=> $avg2,
                'rating' => $rat,
                'surname' => $teachers[$i]->teacher_surname,
                'name' => $teachers[$i]->teacher_name,
                'subject' => $subjects[0]->subject_name
                
            );
            
            

        }
        return $posts;
        // $group = $request->input("group");
        // $symbol = $request->input("symbol");
        // $subject = $request->input("subject");
        // $marks = DB::table('visit')->orderBy('students.student_surname')
        //     ->join('marks', 'marks.id_visit', '=', 'visit.id_visit')
        //     ->join('lesson', 'lesson.id_lesson', '=', 'visit.id_lesson')
        //     ->join('subjects', 'subjects.id_subject', '=', 'lesson.id_subject')
        //     ->join('students', 'students.student_id', '=', 'visit.student_id')
        //     ->join('class', 'students.id_class', '=', 'class.id_class')
        //     ->select('marks.mark_type', 'marks.mark', 'students.student_name', 'students.student_surname',)
        //     ->where('subjects.subject_name', '=', $subject)
        //     ->where('class.group', '=',  $group)
        //     ->where('class.symbol', '=',  $symbol)
        //     ->get();
        // // $str = "";
        // $str =  $marks[0]->student_name . " " . $marks[0]->student_surname;
        // array_push($arr, $marks[0]->mark);
        // $array[$str] = $arr;
        // // array_push($array[$str], $arr);               
        // $array[$str] = array_push($arr, $marks[0]->mark);
        // for($i = 1; $i <count($marks); $i++){
        //     if($marks[$i]->student_surname != $marks[$i-1]->student_surname){
        //         $arr = [];
        //     } 
        //     $str =  $marks[$i]->student_name . " " . $marks[$i]->student_surname;
        //     array_push($arr, $marks[$i]->mark);
        //     $array[$str] = $arr;               
        //     // $array[$str] = array_push($arr, $marks[$i]->mark);            
        // }
        // $value = json_encode($array,JSON_UNESCAPED_UNICODE);
        // return $value;
    }
    public function GetAllClass()
    {
        $classGroup = [];
        $class = DB::table('class')
            ->select('class.group', 'class.symbol')
            ->get();
        // $str = "";
        foreach($class as $value){
            $str = $value->group . $value->symbol;
            array_push($classGroup, $str);
        }
        return $classGroup;
        
    }
    public function getTeacherClasses(Request $request){
        $data = [];
        $arr = [];
        $id_teacher = $request->user()->id_teacher;
        $class = DB::table('timetable')->groupBy('class.group', 'class.symbol', 'subjects.subject_name')->orderBy('subjects.subject_name')
            ->join('teachers', 'teachers.id_teacher', '=', 'timetable.id_teacher')
            ->join('class', 'class.id_class', '=', 'timetable.id_class')
            ->join('subjects', 'subjects.id_subject', '=', 'timetable.id_subject')
            ->select(
            'class.group', 
            'class.symbol',
            'subjects.subject_name' 
            )
            ->where('teachers.id_teacher', '=', $id_teacher)
            
            ->get();
            $str = $class[0]->group . $class[0]->symbol;
            array_push($arr, $str);
            $data[$class[0]->subject_name] = $arr;
            
            for($i=1;$i<count($class);$i++){
                if($class[$i]->subject_name != $class[$i-1]->subject_name){
                    $arr = [];
                }
                $str = $class[$i]->group . $class[$i]->symbol;
                array_push($arr, $str);
                $data[$class[$i]->subject_name] = $arr;
            }
            // array_push($arr, ($class[0]->group + $class[0]->symbol));
            // $data[$class[0]->subject_name] = $arr;
            return $data;

  
    }
    public function GetTeachersSubjects(Request $request)
    {
        $id_teacher = $request->user()->id_teacher;
        $class = DB::table('teachers')
            ->join('teacher_subjects', 'teacher_subjects.id_teacher', '=', 'teachers.id_teacher')
            ->join('subjects', 'subjects.id_subject', '=', 'teacher_subjects.id_subject')
            ->select(
            'subjects.subject_name', 
            )
            ->where('teachers.id_teacher', '=', $id_teacher)
            ->get();
            return $class;
        
    }
    public function GetMarkTable(Request $request)
    {
        $arr = [];
        $array = [];
        $subject = $request->input('subject');
        $group = $request->input('group');
        $symbol = $request->input('symbol');
        $quarter = $request->input('quarter');
        $year = $request->input('year');
        $date_start = 0;
        $date_end = 0;
        if($year){
            $searchYear = '%' . $year;
        } else{
            $searchYear = 0;
            $year = 0;
        }
        if($quarter){
            if($quarter == 1){
                $date_start = $year . "-" . '08-31';
                $date_end = $year . "-" . '11-05';
            }
            if($quarter == 2){
                $date_start = $year . "-" . '11-06';
                $year += 1;
                $date_end = $year . "-" . '01-15';
            }
            if($quarter == 3){
                $date_start = $year . "-" . '01-16';
                $date_end = $year . "-" . '04-02';
            }
            if($quarter == 4){
                $date_start = $year . "-" . '04-03';
                $date_end = $year . "-" . '06-01';
            }
            if($quarter <1 || $quarter > 4){
                $quarter = 0;
            }
        }
        if($quarter != 0 && $searchYear!=0){
            $date = DB::table('lesson')
            ->select('lesson.date_visit')->orderBy('lesson.date_visit')
            ->join('class', 'class.id_class', '=', 'lesson.id_class')
            ->join('subjects', 'subjects.id_subject', '=', 'lesson.id_subject')
            ->where('subjects.subject_name', '=', $subject)
            ->where('class.group', '=',  $group)
            ->where('class.symbol', '=',  $symbol)
            ->where('lesson.date_visit', '>=',  $date_start)
            ->where('lesson.date_visit', '<=',  $date_end)
            ->get();
        } else {
            $date = DB::table('lesson')
            ->select('lesson.date_visit')
            ->join('class', 'class.id_class', '=', 'lesson.id_class')
            ->join('subjects', 'subjects.id_subject', '=', 'lesson.id_subject')
            ->where('subjects.subject_name', '=', $subject)
            ->where('class.group', '=',  $group)
            ->where('class.symbol', '=',  $symbol)
            ->get();
        }
        
        // $marks = DB::table('visit')->orderBy('students.student_surname')
        //     ->join('marks', 'marks.id_visit', '=', 'visit.id_visit')
        //     ->join('lesson', 'lesson.id_lesson', '=', 'visit.id_lesson')
        //     ->join('subjects', 'subjects.id_subject', '=', 'lesson.id_subject')
        //     ->join('students', 'students.student_id', '=', 'visit.student_id')
        //     ->join('class', 'students.id_class', '=', 'class.id_class')
        //     ->select('marks.mark_type', 'marks.mark', 'students.student_name', 'students.student_surname', 'lesson.date_visit')
        //     ->where('subjects.subject_name', '=', $subject)
        //     ->where('class.group', '=',  $group)
        //     ->where('class.symbol', '=',  $symbol)
        //     ->get();
        // $str =  $marks[0]->student_name . " " . $marks[0]->student_surname;
        // array_push($arr, $marks[0]->mark);
        // $array[$str] = $arr;
        // // array_push($array[$str], $arr);               
        // $array[$str] = array_push($arr, $marks[0]->mark);
        // for($i = 1; $i <count($marks); $i++){
        //     if($marks[$i]->student_surname != $marks[$i-1]->student_surname){
        //         $arr = [];
        //     } 
        //     $str =  $marks[$i]->student_name . " " . $marks[$i]->student_surname;
        //     array_push($arr, $marks[$i]->mark);
        //     $array[$str] = $arr;               
        //     // $array[$str] = array_push($arr, $marks[$i]->mark);            
        // }
        // $value = json_encode($array,JSON_UNESCAPED_UNICODE);
        return $date;        
    }
    public function getStudentsVisit(Request $request)
    {
        // $arr = [];
        // $array = [];
        // $subject = $request->input('subject');
        // $group = $request->input('group');
        // $symbol = $request->input('symbol');
        // $date = DB::table('lesson')
        //     ->select('lesson.date_visit','visit.visit','visit.id_visit', 'students.student_surname')
        //     ->join('class', 'class.id_class', '=', 'lesson.id_class')
        //     ->join('visit', 'visit.id_lesson', '=', 'lesson.id_lesson')
        //     ->join('students', 'students.student_id', '=', 'visit.student_id')
        //     ->join('subjects', 'subjects.id_subject', '=', 'lesson.id_subject')
        //     ->where('subjects.subject_name', '=', $subject)
        //     ->where('class.group', '=',  $group)
        //     ->where('class.symbol', '=',  $symbol)
        //     ->get();
        // for($i = 0; $i < count($date); $i++){
        //     $posts[$date[$i]->date_visit] = array(
        //         'date_visit'=> $date, 
        //         'student_surname'=> $students[$student]->student_surname,
        //         'marks' => $arr,
        //         'id_mark' => $id
        //         );
        // }

        
        // $marks = DB::table('visit')->orderBy('students.student_surname')
        //     ->join('marks', 'marks.id_visit', '=', 'visit.id_visit')
        //     ->join('lesson', 'lesson.id_lesson', '=', 'visit.id_lesson')
        //     ->join('subjects', 'subjects.id_subject', '=', 'lesson.id_subject')
        //     ->join('students', 'students.student_id', '=', 'visit.student_id')
        //     ->join('class', 'students.id_class', '=', 'class.id_class')
        //     ->select('marks.mark_type', 'marks.mark', 'students.student_name', 'students.student_surname', 'lesson.date_visit')
        //     ->where('subjects.subject_name', '=', $subject)
        //     ->where('class.group', '=',  $group)
        //     ->where('class.symbol', '=',  $symbol)
        //     ->get();
        // $str =  $marks[0]->student_name . " " . $marks[0]->student_surname;
        // array_push($arr, $marks[0]->mark);
        // $array[$str] = $arr;
        // // array_push($array[$str], $arr);               
        // $array[$str] = array_push($arr, $marks[0]->mark);
        // for($i = 1; $i <count($marks); $i++){
        //     if($marks[$i]->student_surname != $marks[$i-1]->student_surname){
        //         $arr = [];
        //     } 
        //     $str =  $marks[$i]->student_name . " " . $marks[$i]->student_surname;
        //     array_push($arr, $marks[$i]->mark);
        //     $array[$str] = $arr;               
        //     // $array[$str] = array_push($arr, $marks[$i]->mark);            
        // }
        // $value = json_encode($array,JSON_UNESCAPED_UNICODE);
        // return $date;        
    }
    public function GetMarksStudents(Request $request)
    {
        $arr = [];
        $array = [];
        $date = [];
        $id = [];
        $subject = $request->input('subject');
        $group = $request->input('group');
        $symbol = $request->input('symbol');
        $quarter = $request->input('quarter');
        $year = $request->input('year');
        $date_start = 0;
        $date_end = 0;
        if($year){
            $searchYear = '%' . $year;
        } else{
            $searchYear = 0;
            $year = 0;
        }
        if($quarter){
            if($quarter == 1){
                $date_start = $year . "-" . '08-31';
                $date_end = $year . "-" . '11-05';
            }
            if($quarter == 2){
                $date_start = $year . "-" . '11-06';
                $year += 1;
                $date_end = $year . "-" . '01-15';
            }
            if($quarter == 3){
                $date_start = $year . "-" . '01-16';
                $date_end = $year . "-" . '04-02';
            }
            if($quarter == 4){
                $date_start = $year . "-" . '04-03';
                $date_end = $year . "-" . '06-01';
            }
            if($quarter <1 || $quarter > 4){
                $quarter = 0;
            }
        }

        $students = DB::table('students')->orderBy('students.student_surname')            
        ->join('class', 'class.id_class', '=', 'students.id_class')
        ->select('students.student_surname')
        ->where('class.group', '=',  $group)
        ->where('class.symbol', '=',  $symbol)
        ->get();
        // return $students;
        // ->select('marks.mark', 'class.symbol', 'lesson.date_visit', 'students.student_surname', 'marks.id_mark')
        for($student = 0; $student<count($students); $student++){
            // echo $students[$student]->student_surname;
            

            
            if($quarter != 0 && $searchYear!=0){
            $marks = DB::table('lesson')->orderBy('lesson.date_visit')            
            ->join('class', 'class.id_class', '=', 'lesson.id_class')
            ->join('subjects', 'subjects.id_subject', '=', 'lesson.id_subject')
            ->rightjoin('visit', 'visit.id_lesson', '=', 'lesson.id_lesson')
            ->join('students', 'students.student_id', '=', 'visit.student_id')
            ->select('class.symbol', 'lesson.date_visit', 'students.student_surname', 'visit.id_visit','visit.visit')
            ->where('subjects.subject_name', '=', $subject)
            ->where('class.group', '=',  $group)
            ->where('class.symbol', '=',  $symbol)
            ->where('lesson.date_visit', '>=',  $date_start)
            ->where('lesson.date_visit', '<=',  $date_end)
            ->where('students.student_surname', '=', $students[$student]->student_surname)
            ->get();
            } else{
                $marks = DB::table('lesson')->orderBy('lesson.date_visit')            
                ->join('class', 'class.id_class', '=', 'lesson.id_class')
                ->join('subjects', 'subjects.id_subject', '=', 'lesson.id_subject')
                ->rightjoin('visit', 'visit.id_lesson', '=', 'lesson.id_lesson')
                ->join('students', 'students.student_id', '=', 'visit.student_id')
                ->select('class.symbol', 'lesson.date_visit', 'students.student_surname', 'visit.id_visit','visit.visit')
                ->where('subjects.subject_name', '=', $subject)
                ->where('class.group', '=',  $group)
                ->where('class.symbol', '=',  $symbol)
                ->where('students.student_surname', '=', $students[$student]->student_surname)
                ->get();  
            }

            

    // return $marks;
                // $str =  $marks[0]->date_visit . " " . $marks[0]->student_surname;
                array_push($arr, $marks[0]->visit);
                array_push($date, $marks[0]->date_visit);
                array_push($id, $marks[0]->id_visit);
                // $array[$str] = $arr;
                $posts[$student] = array(
                'date_visit'=> $date, 
                'student_surname'=> $students[$student]->student_surname,
                'marks' => $arr,
                'id_mark' => $id
                );
                if(count($marks) == 0){
                    return $posts;
                }
                // return $posts[0];
                // array_push($array[$str], $arr);               
                //$array[$str] = array_push($arr, $marks[0]->mark);
                for($i = 1; $i <count($marks); $i++){
                    // $value = $marks[$i]->mark;
                    if($marks[$i]->student_surname != $marks[$i-1]->student_surname){
                        $arr = [];
                        $date = [];
                        $id = [];
                        // $j++;
                    }
                    // echo $marks[$i]->date_visit;
                    if($marks[$i]->date_visit == $marks[$i-1]->date_visit){
                        // echo $marks[$i]->date_visit . " " . $marks[$i-1]->date_visit . " ";
                        $arr[count($arr)-1] = $arr[count($arr)-1] . "," . $marks[$i]->visit;
                        $id[count($id)-1] = $id[count($id)-1] . "," . $marks[$i]->id_visit;                    
                        // for($k=0; $k<count($arr); $k++){
                        //     echo $arr[$k] . " ";
                        // }
                        // echo $arr[$i-1] ." "  . $i;
                        // $id[$i-1] = $id[$i-1] . "," . $marks[$i]->id_mark;
                        
                    }
                    else{
                        array_push($date, $marks[$i]->date_visit);
                        array_push($arr, $marks[$i]->visit);
                        array_push($id, $marks[$i]->id_visit);
                    } 
                    // $str = $marks[0]->date_visit . " " . $marks[0]->student_surname;
                    
                    
                    // $array[$str] = $arr;
                    $posts[$student] = array(
                        'date_visit'=> $date, 
                        'student_surname'=> $students[$student]->student_surname,
                        'marks' => $arr,
                        'id_mark' => $id
                        );
                //    print_r($posts[$j]);              
                    // $array[$str] = array_push($arr, $marks[$i]->mark);            
                }
                $arr = [];
                $date = [];
                $id = [];
            
        }
        

            
        return $posts;        
    }
    public function getLessonMarks(Request $request){
        $arr = [];
        $array = [];
        $date = [];
        $id = [];
        $mark_type = [];
        $subject = $request->input('subject');
        $group = $request->input('group');
        $symbol = $request->input('symbol');
        $date_visit = $request->input('date_visit');
        $students = DB::table('students')->orderBy('students.student_surname')            
        ->join('class', 'class.id_class', '=', 'students.id_class')
        ->select('*')
        ->where('class.group', '=',  $group)
        ->where('class.symbol', '=',  $symbol)
        ->get();
        // return $students;
        // ->select('marks.mark', 'class.symbol', 'lesson.date_visit', 'students.student_surname', 'marks.id_mark')
        for($student = 0; $student<count($students); $student++){
            // echo $students[$student]->student_surname;
            $marks = DB::table('lesson')->orderBy('lesson.date_visit')
            
            ->join('class', 'class.id_class', '=', 'lesson.id_class')
            ->join('subjects', 'subjects.id_subject', '=', 'lesson.id_subject')
            ->rightjoin('visit', 'visit.id_lesson', '=', 'lesson.id_lesson')
            ->join('marks', 'marks.id_visit', '=', 'visit.id_visit')
            ->join('students', 'students.student_id', '=', 'visit.student_id')
            ->select(
            'marks.mark', 
            'class.symbol', 
            'lesson.date_visit', 
            'students.student_surname', 
            'marks.id_mark', 
            'marks.mark_type',
            'visit.visit',
            'visit.id_visit'
            )
            ->where('subjects.subject_name', '=', $subject)
            ->where('class.group', '=',  $group)
            ->where('class.symbol', '=',  $symbol)
            ->where('lesson.date_visit', '=', $date_visit)
            ->where('students.student_id', '=', $students[$student]->student_id)
            ->get();
            
            if(count($marks) == 0){
            $getVisit = DB::table('lesson')->orderBy('lesson.date_visit')            
            ->join('class', 'class.id_class', '=', 'lesson.id_class')
            ->join('subjects', 'subjects.id_subject', '=', 'lesson.id_subject')
            ->rightjoin('visit', 'visit.id_lesson', '=', 'lesson.id_lesson')
            ->join('students', 'students.student_id', '=', 'visit.student_id')
            ->select(
            'visit.visit', 'visit.id_visit'
            )
            ->where('subjects.subject_name', '=', $subject)
            ->where('class.group', '=',  $group)
            ->where('class.symbol', '=',  $symbol)
            ->where('lesson.date_visit', '=', $date_visit)
            ->where('students.student_id', '=', $students[$student]->student_id)
            ->where('visit.visit', '=', 'Б')
            ->get();
                array_push($date, $date_visit);
                array_push($mark_type, 0);
                $posts[$student] = array(
                    'date_visit'=> $date, 
                    'student_surname'=> $students[$student]->student_surname,
                    'marks' => 0,
                    'id_mark' => 0,
                    'id_visit' => $getVisit[0]->id_visit,
                    'visit' => $getVisit[0]->visit,
                    'mark_type' => $mark_type
                );
                $date = [];
                $mark_type = [];
            }
            else{
                array_push($arr, $marks[0]->mark);
                array_push($date, $marks[0]->date_visit);
                array_push($id, $marks[0]->id_mark);
                array_push($mark_type, $marks[0]->mark_type);
                // $array[$str] = $arr;
                $posts[$student] = array(
                'date_visit'=> $date, 
                'student_surname'=> $students[$student]->student_surname,
                'marks' => $arr,
                'id_mark' => $id,
                'visit' => $marks[0]->visit,
                'id_visit' => $marks[0]->id_visit,
                'mark_type' => $mark_type
                );
                if(count($marks) == 0){
                    return $posts;
                }
                // return $posts[0];
                // array_push($array[$str], $arr);               
                //$array[$str] = array_push($arr, $marks[0]->mark);
                for($i = 1; $i <count($marks); $i++){
                    $value = $marks[$i]->mark;
                    if($marks[$i]->student_surname != $marks[$i-1]->student_surname){
                        $arr = [];
                        $date = [];
                        $id = [];
                        $mark_type = [];
                        // $j++;
                    }

                    if($marks[$i]->date_visit == $marks[$i-1]->date_visit){
    
                        $arr[count($arr)-1] = $arr[count($arr)-1] . "," . $marks[$i]->mark;
                        $id[count($id)-1] = $id[count($id)-1] . "," . $marks[$i]->id_mark; 
                        $mark_type[count($mark_type)-1] = $mark_type[count($mark_type)-1] . "," . $marks[$i]->mark_type;                    
        
                        
                    }
                    else{
                        array_push($date, $marks[$i]->date_visit);
                        array_push($arr, $marks[$i]->mark);
                        array_push($id, $marks[$i]->id_mark);
                        array_push($mark_type, $marks[$i]->mark_type);
                    } 
                    // $str = $marks[0]->date_visit . " " . $marks[0]->student_surname;
                    
                    
                    // $array[$str] = $arr;
                    $posts[$student] = array(
                        'date_visit'=> $date, 
                        'student_surname'=> $students[$student]->student_surname,
                        'marks' => $arr,
                        'id_mark' => $id,
                        'visit' => $marks[0]->visit,
                        'id_visit' => $marks[0]->id_visit,
                        'mark_type' => $mark_type
                        );
                //    print_r($posts[$j]);              
                    // $array[$str] = array_push($arr, $marks[$i]->mark);            
                }
                $arr = [];
                $date = [];
                $id = [];
                $mark_type = [];
            }

    // return $marks;
                // $str =  $marks[0]->date_visit . " " . $marks[0]->student_surname;
                
            
        }
        

            
        return $posts;  
    }
    public function getVisitDashboard(Request $request){

        $subject = $request->input('subject');
        $group = $request->input('group');
        $symbol = $request->input('symbol');
        $allVisit = DB::table('lesson')           
        ->join('visit', 'visit.id_lesson', '=', 'lesson.id_lesson')
        ->join('students', 'students.student_id', '=', 'visit.student_id')
        ->join('subjects', 'subjects.id_subject', '=', 'lesson.id_subject')
        ->join('class', 'class.id_class', '=', 'students.id_class')
        ->select('*')
        ->where('class.group', '=',  $group)
        ->where('class.symbol', '=',  $symbol)
        ->where('subjects.subject_name', '=',  $subject)
        ->get();
        $students = DB::table('students')->orderBy('students.student_surname')            
        ->join('class', 'class.id_class', '=', 'students.id_class')
        ->select('*')
        ->where('class.group', '=',  $group)
        ->where('class.symbol', '=',  $symbol)
        ->get();
        $posts[0] = array(
            'count'=> count($allVisit), 
            'name'=> 'Всего',
        );
        $j = 1;
        // return $students;
        // ->select('marks.mark', 'class.symbol', 'lesson.date_visit', 'students.student_surname', 'marks.id_mark')
        for($student = 0; $student<count($students); $student++){
            // echo $students[$student]->student_surname;
            $allVisit = DB::table('lesson')           
            ->join('visit', 'visit.id_lesson', '=', 'lesson.id_lesson')
            ->join('students', 'students.student_id', '=', 'visit.student_id')
            ->join('subjects', 'subjects.id_subject', '=', 'lesson.id_subject')
            ->join('class', 'class.id_class', '=', 'students.id_class')
            ->select('*')
            ->where('class.group', '=',  $group)
            ->where('class.symbol', '=',  $symbol)
            ->where('subjects.subject_name', '=',  $subject)
            ->where('students.student_id', '=',  $students[$student]->student_id)
            ->get();
            
            if(count($allVisit) == 0){

                $posts[$j] = array(
                    'count'=> 0, 
                    'name'=> $students[$student]->student_surname,
                );
            }
            else{
                $posts[$j] = array(
                    'count'=> count($allVisit), 
                    'name'=> $students[$student]->student_surname,
                );         
                }
            $j++;    
  
            }

    // return $marks;
                // $str =  $marks[0]->date_visit . " " . $marks[0]->student_surname;
                
                return $posts;   
        }
        

            
         
    
    public function GetStudentsMarks(Request $request)
    {
        $arr = [];
        $array = [];
        $subject = $request->input('subject');
        $group = $request->input('group');
        $symbol = $request->input('symbol');
        $date = DB::table('lesson')
            ->select('lesson.date_visit')
            ->join('class', 'class.id_class', '=', 'lesson.id_class')
            ->join('subjects', 'subjects.id_subject', '=', 'lesson.id_subject')
            ->where('subjects.subject_name', '=', $subject)
            ->where('class.group', '=',  $group)
            ->where('class.symbol', '=',  $symbol)
            ->get();
        // $marks = DB::table('visit')->orderBy('students.student_surname')
        //     ->join('marks', 'marks.id_visit', '=', 'visit.id_visit')
        //     ->join('lesson', 'lesson.id_lesson', '=', 'visit.id_lesson')
        //     ->join('subjects', 'subjects.id_subject', '=', 'lesson.id_subject')
        //     ->join('students', 'students.student_id', '=', 'visit.student_id')
        //     ->join('class', 'students.id_class', '=', 'class.id_class')
        //     ->select('marks.mark_type', 'marks.mark', 'students.student_name', 'students.student_surname', 'lesson.date_visit')
        //     ->where('subjects.subject_name', '=', $subject)
        //     ->where('class.group', '=',  $group)
        //     ->where('class.symbol', '=',  $symbol)
        //     ->get();
        // $str =  $marks[0]->student_name . " " . $marks[0]->student_surname;
        // array_push($arr, $marks[0]->mark);
        // $array[$str] = $arr;
        // // array_push($array[$str], $arr);               
        // $array[$str] = array_push($arr, $marks[0]->mark);
        // for($i = 1; $i <count($marks); $i++){
        //     if($marks[$i]->student_surname != $marks[$i-1]->student_surname){
        //         $arr = [];
        //     } 
        //     $str =  $marks[$i]->student_name . " " . $marks[$i]->student_surname;
        //     array_push($arr, $marks[$i]->mark);
        //     $array[$str] = $arr;               
        //     // $array[$str] = array_push($arr, $marks[$i]->mark);            
        // }
        // $value = json_encode($array,JSON_UNESCAPED_UNICODE);
        return $date;        
    }
    public function setFileLiterature(Request $request){
        
        if ($request->hasFile('file')) {
            $file = $request->input('file');
            $name = basename($file);
            $path = $request->file('file','lit')->storeAs('literature','РусЯз.docx'); 
            $url = 'http://127.0.0.1:8000/storage/literature/РусЯз.docx';

            DB::table('literature')->insert([
                'lit_name' => 'Задачник',
                'lit_url' => $url,
                'id_subject_teacher' => 10007,
                'id_class' => 102,
            ]);
            return $url;

        }
        else{
            return 'Файл не загружен';
        }
        // $path = $file->store('/news');
        // $spreadsheet = new Spreadsheet();
        // $activeWorksheet = $spreadsheet->getActiveSheet();
        // $activeWorksheet->setCellValue('A1', 'Ботки !');
        // $writer = new Xlsx($spreadsheet);
        // $writer->save('storage/news/55.xlsx');
        // $url = 'http://127.0.0.1:8000/storage/news/55.xlsx';
        // return $url;
                
        
        // $path = storage_path('public\files');
        // echo $path;
        // if (Storage::disk('s3')->exists('reports/' . $report->type . '' . $report->uuid . '.xlsx')) { $url = Storage::url('reports/' . $report->type . '' . $report->uuid . '.xlsx'); return redirect($url); }
    }
    public function getFileLiterature(Request $request){
        
        $id = $request->input('id');
        $books = DB::table('literature')
        ->select('lit_name','lit_url')
        ->where('id_subject_teacher','=',$id)
        ->get();
        return $books;
        // $path = $file->store('/news');
        // $spreadsheet = new Spreadsheet();
        // $activeWorksheet = $spreadsheet->getActiveSheet();
        // $activeWorksheet->setCellValue('A1', 'Ботки !');
        // $writer = new Xlsx($spreadsheet);
        // $writer->save('storage/news/55.xlsx');
        // $url = 'http://127.0.0.1:8000/storage/news/55.xlsx';
        // return $url;
                
        
        // $path = storage_path('public\files');
        // echo $path;
        // if (Storage::disk('s3')->exists('reports/' . $report->type . '' . $report->uuid . '.xlsx')) { $url = Storage::url('reports/' . $report->type . '' . $report->uuid . '.xlsx'); return redirect($url); }
    }
    public function getLessons(Request $request){
        
        $id_class = $request->input('id_class');
        $id_subject = $request->input('id_subject');
        $lessons = DB::table('lesson')->orderBy('date_visit')
        ->select('*')
        ->where('id_class','=',$id_class)
        ->where('id_subject','=',$id_subject)
        ->get();
        return $lessons;
        // $path = $file->store('/news');
        // $spreadsheet = new Spreadsheet();
        // $activeWorksheet = $spreadsheet->getActiveSheet();
        // $activeWorksheet->setCellValue('A1', 'Ботки !');
        // $writer = new Xlsx($spreadsheet);
        // $writer->save('storage/news/55.xlsx');
        // $url = 'http://127.0.0.1:8000/storage/news/55.xlsx';
        // return $url;
                
        
        // $path = storage_path('public\files');
        // echo $path;
        // if (Storage::disk('s3')->exists('reports/' . $report->type . '' . $report->uuid . '.xlsx')) { $url = Storage::url('reports/' . $report->type . '' . $report->uuid . '.xlsx'); return redirect($url); }
    }

//     join marks on marks.id_visit = visit.id_visit
// join lesson on lesson.id_lesson = visit.id_lesson
// join subjects on subjects.id_subject = lesson.id_subject
// join students on students.student_id = visit.student_id
// where subjects.subject_name = 'Русский язык'
// and students.student_name = 'Григорий'
}
