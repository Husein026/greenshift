<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Instructors;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AgendaInstructor extends Controller
{



    public function cancelLesson($date)
    {
        $user_id = auth()->id();
        $instructor = Instructors::where('FKLoginId', $user_id)->first();
        
       
        if ($instructor) {
            $instructorId = $instructor->id;
            $formattedDate = $date;
        
            $agenda = Agenda::where('FKInstructorId', $instructorId)
                ->where('date', $formattedDate)
                ->first();
        
            if ($agenda) {

                $agenda->delete();
        
                return redirect()->route('agenda.instructor')->with('message', 'Lesson canceled successfully!');
            } else {
                return redirect()->route('agenda.instructor')->with('error', 'Lesson not found or already canceled.');
            }
        } else {
            return redirect()->route('agenda.instructor')->with('error', 'Instructor not found.');
        }
    }
}
