<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="api-token" content="{{ Auth::check() ? Auth::user()->createToken('authenticated')->plainTextToken : '' }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
          rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="cbp-spmenu-push">
@include('common.nav')

<div class="container-fluid">
    <div class="row">
        <main role="main" class="col-12 ml-sm-auto px--15">
            <div class="row row-eq-height row-nav">
                <div class="col-3 d-flex float-col align-items-center justify-content-start">
                    <button class="hamburger hamburger--collapse float-right" type="button" aria-label="MENU">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                    </button>
                </div>
                <div class="col-9 d-flex float-col align-items-center justify-content-end text-right">
                    <h1 class="logo">{{ strtoupper(__('tenant panel')) }}</h1>
                </div>
            </div>

            @yield('content')
        </main>
    </div>
</div>
</body>
</html>
