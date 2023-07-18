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
        
        return $date;        
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
    public function GetStudentsMarks(Request $request)
    {
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
        return $date;        
    }
}
