<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @auth
        <meta name="api-token" content="{{ auth()->user()->api_token }}">
    @endauth

    <title>{{ config('app.name', 'Laravel') }}</title>
    <script>

        window.App=@json(leven());
        window.Language = '{{ config('app.locale') }}';

        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>


          window.app=@json($public);
    </script>

    <script>
        {{--window.TS = {!!--}}
            {{--json_encode([--}}

                {{--'api'       => $public['api'],--}}
                {{--'baseURL'   => $base_url,--}}
                {{--'csrfToken' => $csrf_token,--}}
                {{--'logged'    => $logged,--}}
                {{--'user'      => $user,--}}
                {{--'token'     => $token,--}}

            {{--])--}}
        {{--!!};--}}
    </script>
    <!-- Styles -->
    <link href="{{ asset('assets/web/css/app.css') }}" rel="stylesheet">

 </head>
<body class="bg-light">
    <div id="app">
        @include('shared/navbar')

        <div class="container">
            @include('shared/alerts')

            <div class="row">
                <div class="col-md-12">
                    @yield('content')
                </div>
            </div>
        </div>

        @include('shared/footer')
    </div>

    <!-- Scripts -->
    @if (Request::is('posts/*'))
        <script src="//{{ Request::getHost() }}:8888/socket.io/socket.io.js"></script>
    @endif

    <script src="{{ asset('assets/web/js/manifest.js') }}"></script>
    <script src="{{ asset('assets/web/js/vendor.js') }}"></script>
    <script src="{{ asset('assets/web/js/app.js') }}"></script>

    @stack('inline-scripts')
</body>
</html>
