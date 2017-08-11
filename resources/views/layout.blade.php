<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>
            Totem
            @yield('page-title')
        </title>

        <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('/vendor/totem/css/app.css') }}">
        @yield('style')
    </head>
    <body>
        <main id="root">
            <div class="wrapper df pv3">
                @include('totem::partials.sidebar')
                <section class="main-content">
                    <div class="panel panel-default mb3">
                        <div class="panel-heading">
                            @yield('title')
                        </div>
                        <div class="panel-content">
                            @yield('main-panel-content')
                            @include('totem::partials.alerts')
                        </div>
                        @yield('main-panel-footer')
                    </div>
                    @yield('additional-panels')
                </section>
            </div>
        </main>
        @include('totem::partials.footer')
        <div style="height: 0; width: 0; position: absolute; visibility: hidden;">
            {!! file_get_contents(public_path('/vendor/totem/img/sprite.svg')) !!}
        </div>
        <script src="{{ asset('/vendor/totem/js/app.js') }}"></script>
        @yield('scripts')
    </body>
</html>
