@extends('layouts.app')

@section('content')
	<app-state-create
		back-url="{{ $backUrl }}"
	></app-state-create>
@endsection