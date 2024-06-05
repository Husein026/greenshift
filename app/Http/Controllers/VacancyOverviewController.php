<?php

namespace App\Http\Controllers;
use App\Models\Package;
use App\Models\User;
use App\Models\package_user;


use Illuminate\Http\Request;

class VacancyOverviewController extends Controller
{

    public function userPackages(){

        $userPackages = package_user::all();
        return view('manager.vacancyoverview')->with('userPackages', $userPackages);
    }



}


    
    
?>
   

