
@extends('layouts.instructor')
@section('title', 'Agenda')
@section('content')
    @php
        $role = '';
            if(Auth::user()->FKRoleId == 1 ) {
                $role = 'Instructor';
            }
            elseif(Auth::user()->FKRoleId == 2 ){
                $role = 'Student';
            }
    @endphp
    <h1 class="text-center">Welcome {{$role}}</h1>
    {{--
        <P class="text-center">Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda maiores quae magni, aut accusamus minus debitis, possimus exercitationem, beatae sed ab nulla ut quam voluptatem porro excepturi eaque? Quidem architecto odit quia minus ratione, suscipit dolor distinctio pariatur, velit error ipsam accusantium doloribus reiciendis animi? Corporis maxime, repellat excepturi placeat praesentium dolorum at suscipit, totam nam nihil aliquid eligendi, ut consequatur deserunt consectetur dolor pariatur eos enim assumenda. Quo nihil neque quam expedita aliquam temporibus, provident ipsa harum earum odit nam ducimus unde fugit molestias voluptatum itaque numquam officiis doloribus sapiente laboriosam, aperiam voluptatibus eos? Vitae, distinctio ratione. Minima, nesciunt?</P>
    --}}
    @php
        $lesson = 'free';
        $dt = new DateTime('now');
        if (isset($_GET['year']) && isset($_GET['week'])) {
            $dt->setISODate($_GET['year'], $_GET['week']);
        } else {
            $dt->setISODate($dt->format('o'), $dt->format('W'));
        }
        $year = $dt->format('o');
        $week = $dt->format('W');
    @endphp
    <div class="text-center my-3">
        <a href="{{ url()->current() }}?week={{ $week-1 }}&year={{ $year }}" class="btn btn-primary">< Previous week</a>
        <span class="mx-2">Week: {{ $week }}</span>
        <a href="{{ url()->current() }}?week={{ $week+1 }}&year={{ $year }}" class="btn btn-primary">Next week ></a>
    </div>
    @if(Session::get('message'))
        <div class="alert alert-success">
            <p class="mb-0 pb-0">{{ Session::get('message') }}</p>
        </div>
    @endif
    <form action="{{ route('agenda.instructor') }}" method="post">
        @csrf
        <div class="card">
            <table class="table table-bordered mt-3">
                <thead>
                <tr>
                    <th>Timeslot</th>
                    @php
                        $currentDate = strtotime('now');
                        for ($day = 0; $day < 5; $day++) {
                           $currentDayOfWeek = $dt->format('N'); // Get the current day of the week (1 for Monday, 2 for Tuesday, etc.)
                        if ($currentDayOfWeek <= 5) {
                            echo "<th>" . $dt->format('l') . "<br>" . $dt->format('d M Y') . "</th>\n";
                        }
                        $dt->modify('+1 day');
                        }
                        $dt->modify('-5 day');
                        $plannedDates = \App\Models\Agenda::getLoggedInInstructorHours();
                        $array = array();
                        foreach($plannedDates as $plannedDate) {
                            array_push($array, $plannedDate->getAttributes());
                        }
                        $dates = array();
                        foreach($array as $date) {
                            array_push($dates, $date['date']);
                        }
                        //dd($dates);
                    @endphp
                </tr>
                </thead>
                <tbody>
                @for ($hours = 8; $hours < 19; $hours++)
                    <tr>
                        <td>{{ $hours }}:00 - {{ $hours + 1 }}:00</td>

                        @php $currentDate = strtotime('now'); @endphp
                        @for ($day = 0; $day < 5; $day++)
                            @php
                                $lesson = null;
                                $formattedDate = date('Y-m-d', $currentDate);
                                $timeslot = $dt->setTime($hours, 00)->format('Y-m-d H:i:s');

                            @endphp

                            @if(Auth::user()->FKRoleId == 2) {{-- Student --}}
                            @if(!in_array($timeslot, $dates))
                                <td><input type="checkbox" name="datetime[]" value="{{ $timeslot }}">  </td>
                            @else
                                <td><input type="checkbox" name="datetime[]" value="{{ $timeslot }}">  </td>
                            @endif
                            @endif

                            @if(Auth::user()->FKRoleId == 1) {{-- Instructor --}}
                            @if(!in_array($timeslot, $dates))
                                <td><input type="checkbox" name="datetime[]" value="{{ $timeslot }}">  </td>
                            @else
                                @php
                                    $filledSlot = array_filter($array, function($date) use ($timeslot) {
                                        return $date['date'] == $timeslot;
                                    });
                                    $userIdArray = array_column($filledSlot, 'FKStudentId');
                                @endphp
                                @if($userIdArray !== null)

                                    @foreach ($userIdArray as $userId)
                                        @php
                                            $student = \App\Models\User::find($userId);
                                        @endphp
                                        @if ($student !== null)
                                            <td style="background-color: rgb(70, 83, 70); color: white; text-align: left;">
                                                <span class="text-white">{{ $student->firstname .' '. $student->insertion.' '. $student->lastname}} </span><br>
                                                <span class="text-white">{{ $student->address .' '. $student->huisnumber.' '. $student->postcode}} </span>
                                            </td>
                                        @else
                                            <td style="background-color: green; color: white; text-align: left;">
                                                Available
                                                <a href="{{ route('cancel.lesson', ['date' => $timeslot]) }}" class="btn btn-link text-danger">Cancel</a>
                                            </td>
                                        @endif
                                    @endforeach
                                @endif
                            @endif
                            @endif

                            @php $currentDate = strtotime('+1 day', $currentDate); @endphp
                            @php $dt->modify('+1 day')  @endphp
                        @endfor
                        @php $dt->modify('-5 day')  @endphp
                    </tr>
                @endfor
                </tbody>
            </table>
        </div>
        <div class="text-center mt-3">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>

@endsection
