<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GetController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\Subject\SubjectController;
use App\Http\Controllers\SearchController; 
use App\Http\Controllers\ProfileGetController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\UserCreateController;
use App\Http\Controllers\Subject\TimeTableController;
use App\Http\Controllers\Subject\MarksController;
use Illuminate\Contracts\Session\Middleware\AuthenticatesSessions;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:sanctum'], function(){
    //Route::get('/get', \App\Http\Controllers\GetController::class,'__invoke');
});

// Auth Controller
Route::get('/get', \App\Http\Controllers\GetController::class,'__invoke');
//Route::get('/student', \App\Http\Controllers\StudentsController::class,'show');
//Route::get('/student', \App\Http\Controllers\StudentsController::class,'show');
Route::resource('students', StudentsController::class);
Route::post('/profile', [StudentsController::class, 'getUser']);
Route::get('/loginout', [AuthenticatedSessionController::class, 'index']); 
Route::post('/getAllStudents', [StudentsController::class, 'getAllStudents']);

// Mark table 
Route::get('/subjects', [SubjectController::class, 'GetAllSubjects']);
Route::post('/subjectsMark', [SubjectController::class, 'GetMarks']);
Route::post('/dateMarks', [SubjectController::class, 'DateMarks']);
Route::post('/subjectsWeight', [SubjectController::class, 'GetWeightMark']);
Route::get('/allClass', [SubjectController::class, 'GetAllClass']);
Route::get('/getAllSubjects', [SubjectController::class, 'GetSubjects']);
Route::get('/getTeachersSubjects', [SubjectController::class, 'GetTeachersSubjects']);
Route::get('/getTeacherClasses', [SubjectController::class, 'getTeacherClasses']);
Route::post('/getMarkTable', [SubjectController::class, 'GetMarkTable']);
Route::post('/getTeacherTable', [SubjectController::class, 'GetMarksStudents']);
Route::post('/getLessonMarks', [SubjectController::class, 'getLessonMarks']);
Route::post('/updateMark', [MarksController::class, 'updateMark']);
Route::post('/setLesson', [MarksController::class, 'setLesson']);  
Route::post('/detailMark', [MarksController::class, 'detailMark']);
Route::post('/updateVisit', [MarksController::class, 'updateVisit']); 
Route::post('/getStudentsVisit', [SubjectController::class, 'getStudentsVisit']);
Route::post('/getLessons', [SubjectController::class, 'getLessons']); 
Route::post('/updateMarkType', [MarksController::class, 'updateMarkType']); 
// Users Profile
Route::post('/search', [SearchController::class, 'contextSearch']);
Route::post('/class', [StudentsController::class, 'getStudentClass']); 
Route::post('/searchTeacher', [SearchController::class, 'searchBySubject']);
Route::get('/profileGet', [ProfileGetController::class, 'show']);  
Route::post('/deleteUser', [UserCreateController::class, 'delete']);

//Dashboard 
Route::post('/subjectsAvg', [SubjectController::class, 'GetAvgMark']);
Route::get('/export', [TimeTableController::class, 'exportXLS']);
Route::post('/timetable', [TimeTableController::class, 'insertTimeTable']);
Route::get('/table', [TimeTableController::class, 'getAllTable']);
Route::post('/dashboardWeight', [SubjectController::class, 'GetDashboardWeight']); 
Route::get('/getTeacherRating', [SubjectController::class, 'GetTeacherRating']);
Route::post('/getVisitDashboard', [SubjectController::class, 'getVisitDashboard']);
Route::post('/setLit', [SubjectController::class, 'setFileLiterature']);
Route::post('/getLit', [SubjectController::class, 'getFileLiterature']);

//timetable
Route::post('/deleteRow', [TimeTableController::class, 'deleteRow']); 

//config
Route::post('/setSubjects', [ConfigController::class, 'setSubjects']);
Route::get('/getDasboard', [ConfigController::class, 'getDasboard']);
Route::get('/getOffices', [ConfigController::class, 'getOffices']); 
Route::post('/setClassRoom', [ConfigController::class, 'setClassRoom']); 
Route::post('/setClass', [ConfigController::class, 'setClass']); 
Route::post('/deleteClassRoom', [ConfigController::class, 'deleteClassRoom']);
Route::post('/deleteClass', [ConfigController::class, 'deleteClass']);
Route::post('/deleteSubject', [ConfigController::class, 'deleteSubject']);
Route::get('/getPosts', [ConfigController::class, 'getPosts']);
Route::post('/setPost', [ConfigController::class, 'setPost']);
Route::post('/deletePost', [ConfigController::class, 'deletePost']);

