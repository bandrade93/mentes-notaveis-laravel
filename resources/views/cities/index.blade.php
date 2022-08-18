@extends('layouts.app')

@section('content')
    <app-city
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
        >
    </app-city>
@endsection