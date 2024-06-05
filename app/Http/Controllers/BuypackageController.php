<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\package_user;
use App\Models\User;

//use Illuminate\Foundation\Auth\User;

use Illuminate\Support\Facades\Auth;

class BuypackageController extends Controller
{
    public function index(){
        $packages = Package::where('isActive', true)->get();

        return view('student.packages')->with('packages', $packages);
    }

    public function selectedPackage(Request $request){

        $user_id = auth()->id();
    
        $user = User::where('FKLoginId', $user_id)->first();
    
        $selectedPackage = new package_user();
        $selectedPackage->FKUserId = $user->id; 
        $selectedPackage->FKPackageId = $request->package_id;
        $selectedPackage->save();

        $package = Package::findOrFail($request->package_id);

        $user->lesson_hours += $package->hours; 
        $user->save();
    
        return redirect('/dashboard')->with('message', 'You bought the package successfully!');
    }
    public function myPackages(){

        $user_id = auth()->id();
        $user = User::where('FKLoginId', $user_id)->first();

        $myPackages =  package_user::where('FKUserId', $user->id)->get();

        $totalBuyedLessons = 0;
        $totalPrice = 0;

        foreach ($myPackages as $mypackage) {
            $totalBuyedLessons += $mypackage->package->hours; // Assuming 'hours' is the attribute representing lesson count
            $totalPrice += $mypackage->package->price;
        }

        $userLessons = $user->lesson_hours ;

        return view('student.myPackages')->with('myPackages', $myPackages)->with('userLessons', $userLessons)->with('totalBuyedLessons', $totalBuyedLessons)->with('totalPrice',$totalPrice);
    }
    
    
}
