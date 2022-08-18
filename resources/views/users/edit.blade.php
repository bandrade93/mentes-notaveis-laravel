@extends('layouts.app')

@section('content')
	<app-user-edit
        :user="{{ $user }}"
		back-url="{{ $backUrl }}"
	></app-user-edit>
@endsection