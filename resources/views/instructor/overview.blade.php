@extends('layouts.instructor')

@section('title', 'Agenda')

@section('content')

@if(Session::get('message'))
<div class="alert alert-success"> 
  <p class="mb-0 pb-0">{{ Session::get('message') }}</p>

</div>
@endif
@if(Session::get('error'))
<div class="alert alert-danger"> 
  <p class="mb-0 pb-0">{{ Session::get('error') }}</p>

</div>
@endif


@endsection
