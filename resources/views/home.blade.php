@extends('layouts.app', ['bodyClass' => 'home'])

@section('body')
    <div class="container">
        @include('layouts._alerts')
    </div>

    <div class="jumbotron text-center">
        <div class="logo"><img src="{{ asset('images/laravelio.png') }}" title="Laravel.io"></div>
        <h2>The Laravel Community Portal</h2>

        <div style="margin-top:40px">
          {{__('site.home')}}
        </div>
    </div>
@endsection
