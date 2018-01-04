@extends('layouts.bootstrap')

@section('title', '后台管理')

@section('head')

    @parent

    <script>
        window.TS = {!!
            json_encode([

                'api'       => $api,
                'baseURL'   => $base_url,
                'csrfToken' => $csrf_token,
                'logged'    => $logged,
                'user'      => $user,
                'token'     => $token,

            ])
        !!};
    </script>

@endsection

@section('body')

    <div id="app"></div>


    <script src="{{ mix('web/js/manifest.js', 'assets') }}"></script>
    <script src="{{ mix('web/js/vendor.js', 'assets') }}"></script>
    @parent
    <script src="{{ mix('js/admin.js', 'assets') }}"></script>

@endsection
