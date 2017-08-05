<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Laravel Totem</title>

        <!-- Horizon UI CSS -->
        <link rel="stylesheet" type="text/css" href="{{ asset('/vendor/totem/css/app.css') }}">
    </head>
    <body>
        @include('totem::partials.header')
        <main>
            <div class="wrapper df">
                @include('totem::partials.sidebar')
                <section class="main-content">
                    <div class="panel panel-default mb3">
                        <div class="panel-heading">
                            @yield('title')

                        </div>
                        <div class="panel-content">
                            <div id="root"></div>
                            @yield('body')
                        </div>
                    </div>
                </section>
            </div>
        </main>
        @include('totem::partials.footer')
        <div style="height: 0; width: 0; position: absolute; visibility: hidden;">
            {!! file_get_contents(public_path('/vendor/totem/img/sprite.svg')) !!}
        </div>
        <script src="{{ asset('/vendor/totem/js/app.js') }}"></script>
    </body>
</html>
