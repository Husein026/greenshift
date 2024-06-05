<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Instructors;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\login;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $instructors = Instructors::where('isActive',true)->get();
        return view('auth.register')->with('instructors', $instructors);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([

            'email' => ['required', 'string', 'email', 'max:255', 'unique:login'],
         //   'password' => ['required', 'confirmed','min:8','regex:/[0-9]/','regex:/[@$!%*#?&]/', Rules\Password::defaults()],
        ]);

        $login = new login();
            $login->email = $request->email;
            $login->password = Hash::make($request->password);
            $login->FKRoleId = 2 ;

        $login->save();
        $login_id = $login->id;

        $user = new User();
            $user->firstname = $request->firstname;
            $user->insertion = $request->instertion;
            $user->lastname = $request->lastname;
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->huisnumber = $request->housenumber;
            $user->postcode = $request->postcode;
            $user->city = $request->city;
            $user->dateOfBirth = $request->dateofbirth;
            $user->bankaccountnumber = $request->bankaccountnumber;
            $user->instructor_id = $request->instructor_id;
            $user->FKLoginId = $login_id;
        $user->save();

       return redirect('dashboard')->with('message', 'Registration successful');
    }
}
