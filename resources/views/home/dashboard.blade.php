
@extends('layouts.vcontrol_dashboard')

@section('add-title')
Dashboard
@endsection

@section('add-css')
{{--  --}}
@endsection

@section('add-navbar-dropdown')
    
@endsection

@section('add-content-title')
    Dashboard
@endsection

@section('add-content')
    Welcome back, {{ session('user')['name'] ?? 'Sir' }}!
@endsection

@section('add-js')
    
@endsection