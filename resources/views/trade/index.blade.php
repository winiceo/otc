@extends('layouts.app')

@section('content')

    <div class="container setting">
        <div class="row">
            {{--<div class="col-md-4">--}}
                {{--@include('trade.particals.sidebar')--}}
            {{--</div>--}}

            <div class="col-md-12">
                @include('widgets.trade')

                {{ $adverts->links('pagination.default') }}

            </div>
        </div>
    </div>
@endsection