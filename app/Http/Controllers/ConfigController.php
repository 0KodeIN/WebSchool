<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Html;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ConfigController extends Controller
{
    public function setSubjects(Request $request){
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $request->file('file','timetable')->storeAs('news','timetable.xlsx');
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
            $worksheet = $spreadsheet->getActiveSheet();
            $highestRow = $worksheet->getHighestRow(); // e.g. 10
            $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
            $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);
            $array = []; $i = 0; $j = 0;

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

                }
                $i++; $j = 0;
               
            }
           
            $j = 0;
           
            for ($i = 0; $i < $highestRow-1; $i++) {
                
                    DB::table('subjects')->insert([
                        'subject_name' => $array[$i][0],
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
    }
    public function setClassRoom(Request $request){
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
                
                    DB::table('classroom')->insert([
                        'class_number' => $array[$i][0],
                        'class_id' => $array[$i][0],
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
    }
    public function setClass(Request $request){
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
                }
                $i++; $j = 0;

            }

            $j = 0;

            for ($i = 0; $i < $highestRow-1; $i++) {
                $teacher = DB::table('teachers')
                ->select('*')
                ->where('teacher_surname','=',$array[$i][1])
                ->get();
                
                    DB::table('class')->insert([
                        'id_class' => $array[$i][0],
                        'id_program' => 71,
                        'id_teacher' => $teacher[0]->id_teacher,
                        'group' =>  $array[$i][2],
                        'symbol' =>  $array[$i][3],
                    ]);

            }

        }
        else{
            return 'Файл не загружен';
        }
    }
    public function getOffices(){

        $offices = DB::table('classroom')
            ->select('*')
            ->get();
        return $offices;
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
       
    }
    public function getPosts(){

        $posts = DB::table('posts')
            ->select('*')
            ->get();
        return $posts;
    }
    public function setPost(Request $request){
        $header = $request->input('header');
        $content = $request->input('content');
        $posts = DB::table('posts')->insert([
            'header' =>  $header,
            'content' => $content
        ]);
        return $posts;
    }
    public function deleteClassRoom(Request $request){
        $id = $request->input('class_id');
        $response = DB::table('classroom')->where('class_id', '=', $id)->delete();

        return $response;
    }
    public function deleteSubject(Request $request){
        $id = $request->input('id_subject');
        $response = DB::table('subjects')->where('id_subject', '=', $id)->delete();

        return $response;
    }
    public function deletePost(Request $request){
        $id = $request->input('post_id');
        $response = DB::table('posts')->where('post_id', '=', $id)->delete();

        return $response;
    }
    public function deleteClass(Request $request){
        $id = $request->input('id_class');
        $response = DB::table('class')->where('group', '=', $id[0])->where('symbol', '=', 'б')->delete();
        return $response;
    }
public function getDasboard(Request $request){
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

$section = $phpWord->addSection();

$section->addText(
    '"Learn from yesterday, live for today, hope for tomorrow. '
        . 'The important thing is not to stop questioning." '
        . '(Albert Einstein)'
);


$section->addText(
    '"Great achievement is usually born of great sacrifice, '
        . 'and is never the result of selfishness." '
        . '(Napoleon Hill)',
    array('name' => 'Tahoma', 'size' => 10)
);

// Adding Text element with font customized using named font style...
$fontStyleName = 'oneUserDefinedStyle';
$phpWord->addFontStyle(
    $fontStyleName,
    array('name' => 'Tahoma', 'size' => 10, 'color' => '1B2232', 'bold' => true)
);
$section->addText(
    '"The greatest accomplishment is not in never falling, '
        . 'but in rising again after you fall." '
        . '(Vince Lombardi)',
    $fontStyleName
);

$fontStyle = new \PhpOffice\PhpWord\Style\Font();
$fontStyle->setBold(true);
$fontStyle->setName('Tahoma');
$fontStyle->setSize(13);
$myTextElement = $section->addText('"Believe you can and you\'re halfway there." (Theodor Roosevelt)');
$myTextElement->setFontStyle($fontStyle);

$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
$objWriter->save('helloWorld.docx');

$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'ODText');
$objWriter->save('helloWorld.odt');

$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
$objWriter->save('helloWorld.html');
$url = 'http://127.0.0.1:8000/helloWorld.docx';
return $url;
}
}
