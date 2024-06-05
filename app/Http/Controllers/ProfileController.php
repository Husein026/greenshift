<?php

namespace App\Http\Controllers;

use App\Models\AuditTrail;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(): View
    {
        $userId = \App\Models\User::where('FKLoginId', Auth::user()->id)->first();


        if (!$userId) {
            abort(404); // Handel het geval af waarin de gebruiker niet wordt gevonden
        }

        // Haal de 'login' gegevens op
        $loginData = \App\Models\Login::find(Auth::user()->id);

        // Als de 'login' gegevens niet worden gevonden, ga dan om met de situatie
        if (!$loginData) {
            abort(404);
        }

        // Combineer de gegevens in een enkele array
        $user = array_merge($userId->getAttributes(), ['email' => $loginData->email]);

        return view('profile.edit', [

            'user' => $user,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {

        // Valideer de gegevens van het verzoek
        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255',
            'insertion' => 'nullable|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'huisnumber' => 'required|string|max:255',
            'postcode' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'dateOfBirth' => 'required|date|max:255',
            'bankaccountnumber' => 'required|string|max:255',
        ]);
        AuditTrail::logUserUpdateBasic($validatedData, 'users');

        // Haal de huidige ingelogde gebruiker op
        $loggedInUser = Auth::user();

        // Update de 'User'-tabel
        \App\Models\User::where('FKLoginId', $loggedInUser->id)->update([
            'firstname' => $validatedData['firstname'],
            'insertion' => $validatedData['insertion'],
            'lastname' => $validatedData['lastname'],
            'phone' => $validatedData['phone'],
            'address' => $validatedData['address'],
            'huisnumber' => $validatedData['huisnumber'],
            'postcode' => $validatedData['postcode'],
            'city' => $validatedData['city'],
            'dateOfBirth' => $validatedData['dateOfBirth'],
            'bankaccountnumber' => $validatedData['bankaccountnumber'],
        ]);

        // Update het e-mailveld in de 'Login'-tabel
        \App\Models\Login::where('id', $loggedInUser->id)->update(['email' => $validatedData['email']]);

        // Voeg een succesmelding toe
        session()->flash('status', 'Profile updated successfully!');

        return Redirect::to('/profile');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(): RedirectResponse
    {
        $user = Auth::user();

        Auth::logout();

        $user->delete();

        session()->invalidate();
        session()->regenerateToken();

        return Redirect::to('/');
    }
}
