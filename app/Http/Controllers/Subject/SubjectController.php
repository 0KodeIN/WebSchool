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

                
                return $posts;   
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
        
    }

}
