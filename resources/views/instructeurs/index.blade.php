@extends('layouts.manager')

@section('title', 'Instructeurs')

@section('content')


    <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
    <span>Instructors</span>
    <a href="{{ url('/instructeurs/create') }}" class="btn btn-primary" id="addInstructorBtn">Add Instructor</a>
    </div>
    <div class="card-body">


    <table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Email</th>
      <th scope="col">Firstname</th>
      <th scope="col">Insertion</th>
      <th scope="col">Lastname</th>
      <th scope="col">Edit</th>
      <th scope="col">Delete</th>


    </tr>
  </thead>
  <tbody>
  @if(count($instructors) > 0)

        @if(session('message'))
            <div class="text-center">
                <p class="alert alert-secondary">{{ session('message') }}</p>
            </div>
        @endif



      @foreach( $instructors as $instructor)

    <tr>

      <td>{{$instructor->login->email}}</td>
      <td>{{$instructor->firstname}}</td>
      @if(($instructor->insertion) > 0)
      <td>{{$instructor->insertion}} </td>
      @else
      <td></td>
      @endif
      <td>{{$instructor->lastname}} </td>
      <td><a href="{{ url('/instructeurs/' . $instructor->id . '/edit') }}" class="btn btn-primary">Edit</a></td>
      <td>
      <form action="{{ route('instructeurs.destroy', ['instructeur' => $instructor->id]) }}" method="post">
          @csrf
          @method('delete') {{-- Use 'delete' method for the destroy action --}}
          <button type="submit" class="btn btn-danger"  onclick="return confirm('Are you sure you want to delete?')">Delete</button>
      </form>
      </td>
    </tr>
    @endforeach

    @else
    <p class="alert ">No instructor founded!</p>
    @endif


  </tbody>
</table>
    </div>
    </div>
@endsection

