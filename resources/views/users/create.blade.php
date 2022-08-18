@extends('layouts.app')

@section('content')
	<app-user-create
		back-url="{{ $backUrl }}"
	></app-user-create>
@endsection