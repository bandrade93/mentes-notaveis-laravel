@extends('layouts.app')

@section('content')
    <app-state
        :allows="{
                enableMulti: true,
                disableMulti: true,
                deleteMulti: true,
                create: true,
                show: true,
                edit: true,
                delete: true,
            }"   
        :columns="{{ json_encode($columns) }}"
        :status="{{ json_encode($status) }}"
        >
    </app-state>
@endsection