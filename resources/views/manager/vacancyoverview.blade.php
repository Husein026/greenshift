@extends('layouts.manager')

@section('title', 'Vacancy Overview')


@section('content')
<div class="ml-4 text-center text-sm text-gray-500 dark:text-gray-400 sm:text-right sm:ml-5">
    <h2>Vacancy overview</h2><br>
</div>
<div class="container">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                @if(count($userPackages) > 0)
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Firstname:</th>
                            <th>Insertion:</th>
                            <th>Lastname:</th>
                            <th>Phone:</th>
                            <th>Street:</th>
                            <th>Housenumber:</th>
                            <th>Zipcode:</th>
                            <th>City:</th>
                            <th>Date of birth:</th>
                            <th>Lessen still have:	</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($userPackages->unique('FKUserId') as $userPackage)
                        <tr>
                            <td>
                                <button class="btn btn-default btn-xs btn-collapse btn-primary" data-toggle="collapse" data-target="#demo{{ $userPackage->id }}">
                                    <span class="glyphicon glyphicon-eye-open"></span>Vacancy overview
                                </button>
                            </td>
                            <td>{{ $userPackage->user->firstname}}</td>
                            <td>{{ $userPackage->user->insertion}}</td>
                            <td>{{ $userPackage->user->lastname}}</td>
                            <td>{{ $userPackage->user->phone}}</td>
                            <td>{{ $userPackage->user->address}}</td>
                            <td>{{ $userPackage->user->huisnumber}}</td>
                            <td>{{ $userPackage->user->postcode}}</td>
                            <td>{{ $userPackage->user->city}}</td>
                            <td>{{ $userPackage->user->dateOfBirth}}</td>
                            <td>{{ $userPackage->user->lesson_hours}}</td>
                            @php
                                $userPackageId = $userPackage->FKUserId;
                            @endphp


                        </tr>
                        <tr class="hiddenRow">
                            <td colspan="6">
                                <div class="accordian-body collapse" id="demo{{ $userPackage->id }}">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr class="info">
                                                <th>Name:</th>
                                                <th>Hours:</th>
                                                <th>Price:</th>

                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            @foreach($userPackages->where('FKUserId', $userPackageId) as $package)
                                            <tr>
                                                <td>{{ $package->package->name }}</td>
                                                <td>{{ $package->package->hours }}</td>
                                                <td>{{ $package->package->price }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p class="alert ">No Vacancy founded</p>

                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Add a click event handler to open and close the collapse
    $(".btn-collapse").click(function() {
        var $row = $(this).closest('tr');
        var $collapse = $row.next('.hiddenRow');
        
        if ($collapse.hasClass('in')) {
            $collapse.collapse('hide');
        } else {
            $collapse.collapse('show');
        }
    });
});
</script>
@endsection






