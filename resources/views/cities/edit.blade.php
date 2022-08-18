@extends('layouts.app')

@section('content')
	<app-city-edit
        :city="{{ $city }}"
		back-url="{{ $backUrl }}"
	></app-city-edit>
@endsection