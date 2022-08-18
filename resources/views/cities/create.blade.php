@extends('layouts.app')

@section('content')
	<app-city-create
		back-url="{{ $backUrl }}"
	></app-city-create>
@endsection