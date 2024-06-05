<?php
namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentsController extends Controller
{
    public function showAgendaView()
    {
        return view('student.agendaview');
    }

    public function cancelLessonStudent($date)
    {
        $user_id = auth()->id();
        $student = User::where('FKLoginId', $user_id)->first();

        if ($student) {
            $studentId = $student->id;
            $formattedDate = $date;

            $agenda = Agenda::where('FKStudentId', $studentId)
                ->where('date', $formattedDate)
                ->first();

            if ($agenda) {
                $agenda->update(['FKStudentId' => null]);

                // Verhoog het aantal resterende lessen van de student
                $student->increment('lesson_hours');

                return redirect()->route('agenda.student')->with('message', 'Lesson canceled successfully!');
            } else {
                return redirect()->route('agenda.student')->with('error', 'Lesson not found or already canceled.');
            }
        } else {
            return redirect()->route('agenda.student')->with('error', 'Instructor not found.');
        }
    }

    public function createPlanStudent(Request $request)
    {


        $user = User::where('FKLoginId', Auth::user()->id)->first();
        $userInfo = $user->getAttributes();

        $input = $request->all();

        // Controleer of de 'datetime'-sleutel bestaat in $input
        if (!array_key_exists('datetime', $input)) {
            return redirect()->route('agenda.student')->with('error', 'Geen beschikbaarheid geselecteerd!');
        }

        $plannedDates = Agenda::getInstructorHours();
        $array = array();

        foreach ($plannedDates as $plannedDate) {
            array_push($array, $plannedDate->getAttributes());
        }

        $dates = array_column($array, 'date');

        $selectedDatesCount = count($input['datetime']);

        // Controleer of de student probeert meer dan 3 blokken te reserveren
        if ($selectedDatesCount > 3) {
            return redirect()->route('agenda.student')->with('error', 'Je kunt slechts maximaal 3 blokken per week reserveren.');
        }
        if($user->lesson_hours > 0 && $user->lesson_hours <= $selectedDatesCount){
            return redirect()->route('agendaview')->with('error', 'Je hebt geen resterende lessen meer. Koop lessen om verder te kunnen reserveren.');

        }

        // maak de if statement voor de lessen die je over hebt  en de lessen die je wilt reserveren
        if($user->lesson_hours > 0 && $user->lesson_hours <= $selectedDatesCount){
            return redirect()->route('agendaview')->with('error', 'Je hebt geen resterende lessen meer. Koop lessen om verder te kunnen reserveren.');

        }


        // Controleer en update het aantal reserveringen van de student per week
        foreach ($input['datetime'] as $value) {
            $date = new DateTime($value);
            $formattedDate = $date->format('Y-m-d H:i:s');

            // Controleer of de geselecteerde datum op of na de huidige datum ligt
            if ($date >= new DateTime('today')) {
                $currentWeek = $date->format('oW');
                $currentWeekKey = 'reservations_week_' . $currentWeek;

                // Eerste dag van de week (maandag)
                $firstDayOfWeek = date('Y-m-d', strtotime('last monday', strtotime($formattedDate)));

                // Laatste dag van de week (zondag)
                $lastDayOfWeek = date('Y-m-d', strtotime('next sunday', strtotime($formattedDate)));

                $userReservationsInWeek = Agenda::where('date', '>=', $firstDayOfWeek)
                    ->where('date', '<', date('Y-m-d H:i:s', strtotime($lastDayOfWeek . ' +1 day')))
                    ->where('FKStudentId', $userInfo['id'])
                    ->count();

                if (($userReservationsInWeek + 1) > 3) {
                    return redirect()->route('agenda.student')->with('error', 'Je kunt slechts maximaal 3 blokken per week reserveren.');
                }

                // Sla de reservering op in de database
                $studentPlan = Agenda::updateOrCreate(
                    ['date' => $formattedDate],
                    ['FKStudentId' => $userInfo['id']]
                );



                if ($user->lesson_hours > 0) {
                    // Sla de reservering op in de database
                    $studentPlan = Agenda::updateOrCreate(
                        ['date' => $formattedDate],
                        ['FKStudentId' => $userInfo['id']]
                    );

                    $user->decrement('lesson_hours');

                } else {
                    return redirect()->route('agendaview')->with('error', 'Je hebt geen resterende lessen meer. Koop lessen om verder te kunnen reserveren.');
                }


                } else {

                    return redirect()->route('agendaview')->with('error', 'Je kunt alleen reserveren vanaf de huidige datum of later.');
                }
            }

            return redirect()->route('agenda.student')->with('message', 'Beschikbaarheid succesvol ingediend!');
        }


}


