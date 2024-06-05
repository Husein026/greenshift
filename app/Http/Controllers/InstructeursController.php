<?php

namespace App\Http\Controllers;

use App\Models\AuditTrail;
use Illuminate\Http\Request;
use App\Models\login;
use App\Models\Instructors;
use App\Models\User;

use Illuminate\Auth\Events\Login as EventsLogin;
use PhpParser\Node\Stmt\Return_;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class InstructeursController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $instructors = Instructors::where('isActive',true)->with('login')->get();
        return view('Instructeurs.index')->with('instructors', $instructors);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('Instructeurs.add');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation rules
        $rules = [
            'email' => 'required|unique:login',
            'password' => ['required','string','min:8','regex:/[0-9]/','regex:/[@$!%*#?&]/',],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = new login();
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->FKRoleId = 1;
        $user->save();

        $loginId = $user->id;

        AuditTrail::logUserRegister('instructors');

        $instructor = new Instructors();
        $instructor->FKLoginId = $loginId;
        $instructor->firstname = $request->firstname;
        $instructor->insertion = $request->insertion;
        $instructor->lastname = $request->lastname;
        $instructor->save();

        return redirect('instructeurs')->with('message', 'Instructor has been added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $instructor = Instructors::find($id);

        if ($instructor) {
            return view('instructeurs.edit', compact('instructor'));
        } else {
            return redirect()->route('instructeurs.index')->with('error', 'Instructor not found.');
        }


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'email' => 'required|string|email|max:255|unique:login,email,'.$id,
           // 'password' => ['required','string','min:8','regex:/[0-9]/','regex:/[@$!%*#?&]/'],
        ];



        $validator = Validator::make($request->all(), $rules);
        //dd($validator->getData());
        AuditTrail::logInstructorUpdateBasic($validator->getData(), 'instructors');
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        } else {
            $instructor = Instructors::find($id);

            if (!$instructor) {
                return redirect('instructeurs')->with('message', 'Instructor not found!');
            }

            $instructor->firstname = $request->firstname;
            $instructor->insertion = $request->insertion;
            $instructor->lastname = $request->lastname;
            $instructor->save();

            $loginId = $instructor->FKLoginId;
            $login = login::find($loginId);

            if (!$login) {
                return redirect('instructeurs')->with('message', 'Login not found!');
            }

            $login->email = $request->email;
            $login->save();

            return redirect('instructeurs')->with('message', 'Instructor has been adjusted!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $instructor = Instructors::find($id);

        if ($instructor) {
            $loginId = $instructor->FKLoginId;

            $instructor->FKLoginId = null;
            $instructor->save();

            if ($loginId) {
                Login::where('id', $loginId)->delete();
            }

            $instructor->isActive = false;
            $instructor->save();

            $students = User::where('instructor_id', $id)->get();

            foreach ($students as $student) {
                // Find a random inactive instructor
                $randomInstructor = Instructors::where('id', '!=', $id)
                    ->where('isActive', true) // Only consider active instructors
                    ->inRandomOrder()
                    ->first();

                if ($randomInstructor) {
                    // Update the instructor of the student
                    $student->instructor_id = $randomInstructor->id;
                    $student->save();
                } else {
                    // Handle the case where no active random instructor is found
                    // You can log an error, send a notification, or handle it based on your application's requirements.
                }
            }

            return redirect()->route('instructeurs.index')->with('message', 'Instructor Deleted successfully.');
        } else {
            return redirect()->route('instructeurs.index')->with('error', 'Instructor not found.');
        }
    }


}
