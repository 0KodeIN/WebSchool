<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;


class UserCreateController extends Controller
{
    public function index()
    {

    }
    public function create(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required'],
        ]);
        Rules\Password::defaults();
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), 
        ]);
        if($request->role == 'Ученик'){
            DB::table('students')->insert([
                'student_name' => $request->p_name,
                'student_surname' => $request->p_surname,
                'student_patronomyc' => $request->p_patronomyc,
                'adress' => $request->adress,
                'phone' => $request->phone,
                'id_class' => 101,
            ]);
            $students = DB::table('students')
            ->select('student_id')
            ->where('student_name', '=', $request->p_name)
            ->get();

            $affected = DB::table('users')
            ->where('name', $request->name)
            ->update(['student_id' => $students[0]->student_id]);

            return $students;
        }
        if($request->role == 'Учитель'){
            DB::table('teachers')->insert([
                'teacher_name' => $request->p_name,
                'teacher_surname' => $request->p_surname,
                'teacher_patronomyc' => $request->p_patronomyc,
                'teacher_phone' => $request->phone,
            ]);
            $teachers = DB::table('teachers')
            ->select('id_teacher')
            ->where('teacher_name', '=', $request->p_name)
            ->get();

            $affected = DB::table('users')
            ->where('name', $request->name)
            ->update(['id_teacher' => $teachers[0]->id_teacher]);

            if($request->subject1 != null){
                $teacher_subject1 = DB::table('subjects')
                ->select('id_subject')
                ->where('subject_name', '=', $request->subject1)
                ->get();
                DB::table('teacher_subjects')->insert([
                    'id_teacher' => $teachers[0]->id_teacher,
                    'id_subject' => $teacher_subject1[0]->id_subject,
                ]);
            }
            if($request->subject2 != null){
                $teacher_subject2 = DB::table('subjects')
                ->select('id_subject')
                ->where('subject_name', '=', $request->subject2)
                ->get();
                DB::table('teacher_subjects')->insert([
                    'id_teacher' => $teachers[0]->id_teacher,
                    'id_subject' => $teacher_subject2[0]->id_subject,
                ]);
            }
            if($request->subject3 != null){
                $teacher_subject3 = DB::table('subjects')
                ->select('id_subject')
                ->where('subject_name', '=', $request->subject3)
                ->get();
                DB::table('teacher_subjects')->insert([
                    'id_teacher' => $teachers[0]->id_teacher,
                    'id_subject' => $teacher_subject3[0]->id_subject,
                ]);
            }

            return $teachers;
        }
        

    }
    public function delete(Request $request)
    {
        $id = $request -> input('id');
        $user = DB::table('users')
        ->select('*')
        ->where('id','=', $id)
        ->get();
        if($user[0]->student_id != null){
            $response = DB::table('users')->where('student_id', '=', $user[0]->student_id)->delete();
            $response = DB::table('students')->where('student_id', '=', $user[0]->student_id)->delete();
        }
        if($user[0]->id_teacher != null){
            $response = DB::table('users')->where('student_id', '=', $user[0]->student_id)->delete();
            $response = DB::table('teachers')->where('id_teacher', '=', $user[0]->id_teacher)->delete();
        }
        return $response;

    }
}
