@extends('layouts.app')

@section('content')
	<app-state-edit
        :state="{{ $state }}"
		back-url="{{ $backUrl }}"
	></app-state-edit>
@endsection