@extends('layouts.manager')

@section('title', 'Add Package')

@section('content')

<div class="container">
    <div class="row">
      <div class="col-md-8 mt-4">
        <div class="card">
          <div class="card-header">
            <h3>Add Package
              <a href="{{ url('/packages') }}" class="btn btn-danger float-end">BACK</a>
            </h3>

          </div>
          <div class="card-body">
            <form action="{{ url('packages') }}" method="POST" enctype="multipart/form-data">
            {!! csrf_field() !!}

                <div class="mb-3">
                    <label>Name of the Package*</label>
                    <input type="text" name="name" required class="form-control" />
                </div>
                <div class="mb-3">
                    <label>Amount of lessons*</label>
                    <input type="number" name="lessons" class="form-control" min="1" required />
                </div>

                <div class="mb-3">
                    <label>Price*</label>
                    <input type="text" name="price" class="form-control" required />
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
                    <button type="submit" class="btn btn-primary">ADD package</button>
                </div>


            </form>

          </div>
        </div>

      </div>
    </div>
  </div>
  @endsection
