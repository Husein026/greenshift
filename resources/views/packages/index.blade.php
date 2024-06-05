@extends('layouts.manager')

@section('title', 'Packages')

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Packages</span>
        <a href="{{ url('/packages/create') }}" class="btn btn-primary" id="addInstructorBtn">Add package</a>
    </div>
    <div class="card-body">
        <div class="table-responsive"> 
            <table class="table" style="width: 70%;"> 
                <thead class="thead-dark">
                    <tr>
                        <th scope="col" style="width: 30%;">Name</th> 
                        <th scope="col" style="width: 20%;">Amount of hours</th> 
                        <th scope="col" style="width: 20%;">Price</th> 
                        <th scope="col" style="width: 30%;">Delete</th> 

                    </tr>
                </thead>
                <tbody>
                    @if(count($packages) > 0)

                    @if(session('message'))
                    <tr>
                        <td colspan="4" class="text-center">
                            <p class="alert alert-secondary">{{ session('message') }}</p>
                        </td>
                    </tr>
                    @endif

                    @foreach($packages as $package)
                    <tr>
                        <td>{{$package->name}}</td>
                        <td>{{$package->hours}}</td>
                        <td>{{$package->price}}</td>
                        <td>
                            <form action="{{ route('packages.destroy', ['package' => $package->id]) }}"
                                method="post">
                                @csrf
                                @method('delete') {{-- Use 'delete' method for the destroy action --}}
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to delete?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach

                    @else
                    <tr>
                        <td colspan="4" class="alert">No package found!</td>
                    </tr>
                    @endif

                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
