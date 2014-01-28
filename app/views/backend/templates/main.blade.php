<!DOCTYPE html>
<html>
<head>
    <title>Pulse Blogging Platform</title>
    <link href="{{ asset('assets/css/admin.css') }}" rel="stylesheet">
</head>
<body>

    @include ('backend.templates._menu')

    <div id="wrapper">
        <div class="l-block-container">
            <div class="l-block-1">
                @yield ('breadcrumb')
            </div>

            @yield ('content')
        </div>
    </div>
</body>
</html>
