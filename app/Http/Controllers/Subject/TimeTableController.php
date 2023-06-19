<?php

namespace App\Http\Controllers\Subject;

use App\Http\Controllers\Controller;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class TimeTableController extends Controller
{
    public function getTimeTable(Request $request){
        $id = $request->input('id');
        $array = [];
        $timeTable = DB::table('visit')
            ->join('marks', 'marks.id_visit', '=', 'visit.id_visit')
            ->join('lesson', 'lesson.id_lesson', '=', 'visit.id_lesson')
            ->join('subjects', 'subjects.id_subject', '=', 'lesson.id_subject')
            ->join('students', 'students.student_id', '=', 'visit.student_id')
            ->select('marks.mark_type', 'marks.mark')
            ->where('subjects.subject_name', '=', $id)
            ->get();
        // $str = "";
        // for($i = 0; $i <count($marks); $i++){                
        //     $array[$marks[$i]->mark_type] = $marks[$i]->mark;            
        // }
        return $timeTable;

    }
    public function exportXLS(){
        


        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();
        $activeWorksheet->setCellValue('A1', 'Ботки !');
        $writer = new Xlsx($spreadsheet);
        $writer->save('storage/news/55.xlsx');
        $url = 'http://127.0.0.1:8000/storage/news/avg.docx';
        return $url;
                
        
        // $path = storage_path('public\files');
        // echo $path;
        // if (Storage::disk('s3')->exists('reports/' . $report->type . '' . $report->uuid . '.xlsx')) { $url = Storage::url('reports/' . $report->type . '' . $report->uuid . '.xlsx'); return redirect($url); }
    }
    public function insertTimeTable(Request $request){
        
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $request->file('file','timetable')->storeAs('news','timetable.xlsx');
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
            $worksheet = $spreadsheet->getActiveSheet();
            $highestRow = $worksheet->getHighestRow(); // e.g. 10
            $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
            $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);
            $array = []; $i = 0; $j = 0;
            //echo '<table>' . "\n";
            for ($row = 2; $row <= $highestRow; ++$row) {
                
                for ($col = 1; $col <= $highestColumnIndex; ++$col) {
                    $value = $worksheet->getCellByColumnAndRow($col, $row)->getValue();
                    if(mb_detect_encoding($value) == "ASCII"){
                        $string = iconv('ASCII', 'UTF-8//IGNORE', $value);
                        $array[$i][$j] = $string;
                       
                    }
                    else{
                        $array[$i][$j] = $value;
                       
                    }
                    $j++;
                    // echo mb_detect_encoding($value) . " ";
                    //echo '<td>' . $value . '</td>' . PHP_EOL;
                }
                $i++; $j = 0;
                //echo '</tr>' . PHP_EOL;
            }
            // echo  $array[1][4] . " "; 
            $j = 0;
            // for($i = 0; $i < 2; $i++){
            //     for($j = 0; $j < 6; $j++){
            //         echo $array[$i][$j] . " ";
            //     }
            // }
            for ($i = 0; $i < $highestRow-1; $i++) {
                
                // for ($j = 0; $j <count($array[$i]);$j++) {
                    // ->join('marks', 'marks.id_visit', '=', 'visit.id_visit')
                    // ->join('lesson', 'lesson.id_lesson', '=', 'visit.id_lesson')
                    // ->join('subjects', 'subjects.id_subject', '=', 'lesson.id_subject')
                    // ->join('students', 'students.student_id', '=', 'visit.student_id')
                    $subject = DB::table('subjects')
                    ->select('id_subject')
                    ->where('subject_name', '=', $array[$i][5])
                    ->get();
                    $subject =  $subject[0]->id_subject;
                    echo $subject . " ";
                    $teacher = DB::table('teachers')
                    ->select('id_teacher')
                    ->where('teacher_surname', '=', $array[$i][4])
                    ->get();                    
                    $teacher = $teacher[0]->id_teacher;
                    echo $teacher . " ";
                    $str = $array[$i][1];
                    $symbol = "%" . $str[0]; 
                    $class = DB::table('class')
                    ->select('id_class')
                    ->where('group', '=', $str[0])
                    // ->whereRaw("symbol like '$symbol'")
                    ->get();
                    
                    
                    $class = $class[0]->id_class;
                    DB::table('timetable')->insert([
                        'week_day' => $array[$i][2],
                        'lesson_time' => $array[$i][3],
                        'class_id' => $array[$i][0],
                        'id_class' => $class,
                        'id_teacher' => $teacher,
                        'id_subject' => $subject,
                    ]);

            }


            //echo '</table>' . PHP_EOL;
            // $activeWorksheet = $spreadsheet->getActiveSheet();
            // $activeWorksheet->setCellValue('A1', 'Ботки !');
            // $writer = new Xlsx($spreadsheet);
            // $writer->save('storage/news/timetable.xlsx');
            // return 'http://127.0.0.1:8000/storage/news/timetable.xlsx';
            // return $array;
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

    public function getAllTable(Request $request){
        // $timeTable = DB::table('timetable')
        // ->select('*')
        // ->get();
        $id_student = $request->user()->student_id;
        $id_teacher = $request->user()->id_teacher;
        if($id_student != null){
            $student = DB::table('users')
            ->join('students', 'users.student_id', '=', 'students.student_id')
            ->select('*')
            ->where('students.student_id', '=', $id_student)
            ->get();
            $id = $id_student;
        }
        if($id_teacher != null){
            $teacher = DB::table('users')
            ->join('teachers', 'users.id_teacher', '=', 'teachers.id_teacher')
            ->select('*')
            ->where('teachers.id_teacher', '=', $id_teacher)
            ->get();
            $id = $id_teacher;
            $timeTable = DB::table('timetable')
            ->join('teachers', 'teachers.id_teacher', '=', 'timetable.id_teacher')
            ->join('classroom', 'classroom.class_id', '=', 'timetable.class_id')
            ->join('subjects', 'subjects.id_subject', '=', 'timetable.id_subject')
            ->join('class', 'class.id_class', '=', 'timetable.id_class')
            ->select(
            'timetable.week_day', 
            'timetable.lesson_time', 
            'teachers.teacher_surname', 
            'class.group', 
            'class.symbol', 
            'subjects.subject_name',
            'classroom.class_id'
            )
            ->where('teachers.teacher_surname', '=', $teacher[0]->teacher_surname)
            // ->where('subjects.subject_name', '=', $id)
            ->get();
            return $timeTable;
        }
        $timeTable = DB::table('timetable')
            ->join('teachers', 'teachers.id_teacher', '=', 'timetable.id_teacher')
            ->join('classroom', 'classroom.class_id', '=', 'timetable.class_id')
            ->join('subjects', 'subjects.id_subject', '=', 'timetable.id_subject')
            ->join('class', 'class.id_class', '=', 'timetable.id_class')
            ->select(
            'timetable.tid_timetable',
            'timetable.week_day', 
            'timetable.lesson_time', 
            'teachers.teacher_surname', 
            'class.group', 
            'class.symbol', 
            'subjects.subject_name',
            'classroom.class_id'
            )
            // ->where('subjects.subject_name', '=', $id)
            ->get();
        return $timeTable;
    }
    public function deleteRow(Request $request){
        $id = $request->input('tid_timetable');
        $response = DB::table('timetable')->where('tid_timetable', '=', $id)->delete();
        return $response;

    }
    
}
