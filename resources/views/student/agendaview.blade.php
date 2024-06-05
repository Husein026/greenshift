<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Student Agenda') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                @if(session('message'))
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        {{ session('message') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="p-6 text-white bg-red-500">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    @php
        $user_id = Auth::user()->id;
        $student = \App\Models\User::where('FKLoginId', $user_id)->first();
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
        <div class="text-left my-3">
            <span class="mx-2">Lessons you still have:{{ $student->lesson_hours }}</span>

        </div>
    @if ($student->lesson_hours > 0)
    <div class="text-center my-3">
        <a href="{{ url()->current() }}?week={{ $week-1 }}&year={{ $year }}" class="btn btn-primary">< Previous week</a>
        <span class="mx-2">Week: {{ $week }}</span>
        <a href="{{ url()->current() }}?week={{ $week+1 }}&year={{ $year }}" class="btn btn-primary">Next week ></a>
    </div>



    <form action="{{ route('agenda.student') }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('POST')

        <div class="card">
            <table class="table table-bordered mt-3">
                <thead>
                <tr>
                    <th>Timeslot</th>
                    @php
                        $currentDate = strtotime('now');
                        for ($day = 0; $day < 5; $day++) {
                            $currentDayOfWeek = $dt->format('N');
                            if ($currentDayOfWeek <= 5) {
                                echo "<th>" . $dt->format('l') . "<br>" . $dt->format('d M Y') . "</th>\n";
                            }
                            $dt->modify('+1 day');
                        }
                        $dt->modify('-5 day');

                        $plannedDates = \App\Models\Agenda::getInstructorHours();
                        $array = array();
                        foreach ($plannedDates as $plannedDate) {
                            array_push($array, $plannedDate->getAttributes());
                        }

                        $dates = array();
                        foreach ($array as $date) {
                            array_push($dates, $date['date']);
                        }
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
                                $scheduledTime = strtotime($timeslot);
                                 $currentTime = strtotime('now');
                                $timeDifference = $scheduledTime - $currentTime;
                            @endphp

                            @if(Auth::user()->FKRoleId == 2) {{-- Student --}}
                            @if(!in_array($timeslot, $dates))
                                <td></td>
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
                                            $user_id = Auth::user()->id;
                                        @endphp
                                        @if ($student !== null)

                                            <td style="background-color: rgb(70, 83, 70); color: white; text-align: left;">
                                                @if ($student->FKLoginId == $user_id)
                                                @if ($timeDifference < 86400)
                                                    <span class="text-white">Planned </span>
                                                @else
                                                    <span class="text-white">Planned </span>
                                                    <span class="text-white">
                                                        <a href="{{ route('cancel.lessonStudent', ['date' => $timeslot]) }}" class="btn btn-link text-danger">Cancel</a>
                                                    </span>
                                                @endif
                                            @else
                                                <span class="text-white">Planned </span>
                                            @endif

                                            </td>
                                        @else
                                            <td style="background-color: green; color: white; text-align: left;">
                                                <input type="checkbox" name="datetime[]" value="{{ $timeslot }}">
                                                Available
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

    @else

    <div class="text-center my-3">
        <span class="mx-2">Buy a lesson package first</span>
        <a href="{{ route('Buy-Package') }}" class="btn btn-primary">Buy</a>

    </div>
    @endif


</x-app-layout>
