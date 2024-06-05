<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My packages') }}
        </h2>
    </x-slot>

<div class="container">
                      
                                
                    <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body text-center">
                                <h3 class="card-title m-b-0">Mij vacancies overview</h3>
                            </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="thead-light">
                                            <tr>
                     
                                                <th scope="col">Name of the package</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Amount of lessons:</th>
                                                <th scope="col">Bought on:</th>
                                            </tr>
                                        </thead>
                                        <tbody class="customtable">

                                           @foreach($myPackages as $mypackage)

                                            <tr>
                        
                                                <td>{{ $mypackage->package->name }}</td>
                                                <td>{{ $mypackage->package->price }}</td>
                                                <td>{{ $mypackage->package->hours}}</td>
                                                <td> {{$mypackage->created_at  }}</td>
                                            </tr>
                                            @endforeach

                                        </tbody>
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col"></th>
                                                <th scope="col">Total Price:</th>
                                                <th scope="col">Total buyed lessons:</th>
                                                <th scope="col">Lessen You still have:</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody class="customtable">


                                        <tr>
                                            <td></td>
                                            <td>{{ $totalPrice }}</td>
                                            <td>{{ $totalBuyedLessons }}</td>
                                            <td>{{ $userLessons }}</td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                        </div>
                    </div>
                </div>

                   </div> 

</x-app-layout>
