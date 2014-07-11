<!DOCTYPE html>
<html>
<head>
    <title>Pulse Blogging Platform</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <link href="{{ asset('assets/css/admin.css') }}" rel="stylesheet">
</head>
<body>

    @include ('backend.templates._menu')

    @include ('backend.templates._flash_messages')

    <div id="wrapper">
        <div class="l-block-container">
            <div class="l-block-1">
                @yield ('breadcrumb')
            </div>

            @yield ('content')
        </div>
    </div>

    <script type="text/javascript" src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/main.min.js') }}"></script>
    <script>window.app = new App; app.init();</script>
</body>
</html>
