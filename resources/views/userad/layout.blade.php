@extends('layouts.app')

@section('content')
    <div class="">
        <div class="usernewout">

            <div class="usncont">
                <!--左侧菜单-->
                @include('userad.particals.side')

                @yield('userright')

            </div>
        </div>
    </div>
@endsection