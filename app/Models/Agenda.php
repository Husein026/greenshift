<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class Agenda extends Model
{
    use HasFactory;

    public $fillable = [
        'FKStudentId',
        'FKInstructorId',
        'date',
        'isActive',
    ];

    public $dt;




    public function getHours() {

    }

    private static function createPlanInstructor($date)
    {
        $user = Instructors::where('FKLoginId', Auth::user()->id)->get();
        $userInfo = $user[0]->getAttributes();
        $InstructorId = $userInfo['id'];
        //dd($InstructorId);

        Agenda::create([
            'FKStudentId' => null,
            'FKInstructorId' => $InstructorId,
            'date' => null,
            'time_start' => null,
        ]);
    }
    public static function getLoggedInInstructorHours() {

        $instructor = \App\Models\Instructors::where('FKLoginId', \Illuminate\Support\Facades\Auth::user()->id)->get();
        $instructor = $instructor[0]->getAttributes();
        $plannedDates = \App\Models\Agenda::where('FKInstructorId', $instructor['id'])->get();

        return $plannedDates;
    }

    public static function getInstructorHours() {

        $loggedInStudent = User::where('FKLoginId', Auth::user()->id)->get();
        $student = $loggedInStudent[0]->getAttributes();
        $hours = Agenda::where('FKInstructorId', $student['instructor_id'])->get();


        return $hours;
    }

    public function instructor()
    {
        return $this->hasOne(Instructors::class, 'FKLoginId', 'id');
    }






}
