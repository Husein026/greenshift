<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Instructors;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AgendainstructorController extends Controller
{
    public function index(){

        return view('Instructor.agenda');

        }

        public function createPlan(Request $request){
            $user = Instructors::where('FKLoginId', Auth::user()->id)->first();
            $userInfo = $user->getAttributes();

            $input = $request->all();

            // Check if 'datetime' key exists in $input
            if (array_key_exists('datetime', $input)) {
                $plannedDates = \App\Models\Agenda::getLoggedInInstructorHours();
                $array = array();

                foreach ($plannedDates as $plannedDate) {
                    array_push($array, $plannedDate->getAttributes());
                }

                $dates = array();
                foreach ($array as $date) {
                    array_push($dates, $date['date']);
                }

                foreach ($input['datetime'] as $key => $value) {
                    if (!in_array($value, $dates)) {
                        $date = new DateTime($value);
                        $plan = new Agenda();
                        $plan->FKStudentId = null;
                        $plan->FKInstructorId = $userInfo['id'];
                        $plan->date = $date;
                        $plan->save();
                    }
                }

                return redirect()->route('agenda.instructor')->with('message', 'Availability submitted successfully!');
            } else {
                return redirect()->route('agenda.instructor')->with('error', 'No availability selected!');
            }


            // $user_id = auth()->id();

            // $user = Instructors::where('FKLoginId', $user_id)->first();
            // $userId = $user[0];



            // $package = Agenda::findOrFail($request->package_id);

            // $user->lesson_hours += $package->hours;
            // $user->save();

            // return redirect()->route('agenda.overview')->with('message', 'Availability submitted successfully!');
        }

        public function cancelLesson($date)
        {
            $user_id = auth()->id();
            $instructor = Instructors::where('FKLoginId', $user_id)->first();

            // Check if an instructor is found
            if ($instructor) {
                $instructorId = $instructor->id;
                $formattedDate = $date;

                // Find the ID of the row by date and instructor ID
                $agenda = Agenda::where('FKInstructorId', $instructorId)
                    ->where('date', $formattedDate)
                    ->first();

                // Check if the agenda is found
                if ($agenda) {
                    // Update isActive column to false
                    $agenda->delete();

                    return redirect()->route('instructor.overview')->with('message', 'Lesson canceled successfully!');
                } else {
                    // ID not found, handle accordingly (e.g., show an error message)
                    return redirect()->route('instructor.overview')->with('error', 'Lesson not found or already canceled.');
                }
            } else {
                // Instructor not found, handle accordingly (e.g., show an error message)
                return redirect()->route('instructor.overview')->with('error', 'Instructor not found.');
            }
        }

}
