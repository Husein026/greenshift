@extends('layouts.manager')

@section('title', 'Edit Instructeurs')

@section('content')

<div class="container">
    <div class="row">
      <div class="col-md-8 mt-4">
        <div class="card">
          <div class="card-header">
            <h3>edit instructor
              <a href="{{ url('/instructeurs') }}" class="btn btn-danger float-end">BACK</a>
            </h3>

          </div>
          <div class="card-body">
            <form action="{{ url('instructeurs/' .$instructor->id) }}" method="POST" enctype="multipart/form-data">
               {!! csrf_field() !!}
               @method("PATCH")

               <input type="hidden" name= "id" value="{{  $instructor->id }}">


                <div class="mb-3">
                    <label>Firstname*</label>
                    <input type="text" name="firstname" value="{{ $instructor->firstname }}" required class="form-control" />
                </div>
                <div class="mb-3">
                    <label>Insertion</label>
                    <input type="text" name="insertion" value="{{ $instructor->insertion }}" class="form-control"/>
                </div>

                <div class="mb-3">
                    <label>Lastname*</label>
                    <input type="text" name="lastname" value="{{ $instructor->lastname }}" class="form-control" required />
                </div>
                <div class="mb-3">
                    <label>Email*</label>
                    <input type="text" name="email" value="{{ $instructor->login->email }}" class="form-control" required />
                </div>
                <div class="mb-3">
                       @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>


            </form>

          </div>
        </div>

      </div>
    </div>
  </div>
  @endsection
