@extends('layouts.bootstrap')

@section('title', 'Plus ID')

@section('head')
    
    <meta name="admin-api-basename" content="{{ url('/genv/plus-id') }}">
    @parent

@endsection

@section('body')

    <div id="app"></div>
    @parent
    <script src="{{ mix('app.js', 'assets/plus-id') }}"></script>

@endsection
