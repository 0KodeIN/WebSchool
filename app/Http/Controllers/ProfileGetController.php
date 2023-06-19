<?php


namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Models\User;

class ProfileGetController extends Controller
{
    public function show(Request $request)
    {
        
        $id_student = $request->user()->student_id;
        $id_teacher = $request->user()->id_teacher;
        $id = $request->user()->id;
        if($id_student != null){
            $user = DB::table('users')
            ->join('students', 'users.student_id', '=', 'students.student_id')
            ->select('*')
            ->where('students.student_id', '=', $id_student)
            ->get();
            return $user;
        }
        if($id_teacher != null){
            $user = DB::table('users')
            ->join('teachers', 'users.id_teacher', '=', 'teachers.id_teacher')
            ->select('*')
            ->where('teachers.id_teacher', '=', $id_teacher)
            ->get();
            return $user;
        }
        $user = DB::table('users')
        ->select('*')
        ->where('id', '=', $id)
        ->get();
        return $user;

    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
