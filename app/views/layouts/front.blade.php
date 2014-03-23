<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <link rel="canonical" href="{{ Request::url() }}" />
        <link href="/favicon.ico" type="image/x-icon" rel="shortcut icon"/>
        <link href="/favicon.ico" type="image/x-icon" rel="icon"/>

        <link href="{{ asset('assets/css/front.css') }}" rel="stylesheet">
    </head>

    <body>
        <div id="l-sidebar" class="m-sidebar">
            @include('front.components._sidebar')
        </div>

        <div id="l-content" class="m-content">
            @yield('content')
        </div>
    </body>
</html>
