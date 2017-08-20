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
            <div class="uk-container uk-section">
                <div class="uk-grid uk-grid-collapse">
                    @include('totem::partials.sidebar')
                    <section class="uk-width-5-6@l">
                        @yield('main-panel-before')
                        <div class="uk-card uk-card-default">
                            <div class="uk-card-header">
                                @yield('title')
                            </div>
                            <div class="uk-card-body">
                                @yield('main-panel-content')
                                @include('totem::partials.alerts')
                            </div>
                            @yield('main-panel-footer')
                        </div>
                        @yield('main-panel-after')
                        @yield('additional-panels')
                        <div class="uk-margin-top">
                            @include('totem::partials.footer')
                        </div>
                    </section>
                </div>
            </div>
        </main>
        <script src="{{ asset('/vendor/totem/js/app.js') }}"></script>
        @yield('scripts')
    </body>
</html>
