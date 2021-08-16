<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="免费素材图片,可以在任何地方使用。✓ 免费用于商业用途 ✓ 无需注明归属" />
    <meta name="keywords" content="免费素材图片,设计资源,高质量,cc0,图库,cc0图库" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'cc0tuku') - CC0图库 - 免费素材图片,免费用于商业用途</title>
    <!-- 样式 -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app" class="{{ route_class() }}-page">
        @include('layouts._header')
        <div class="container-fluid">
            @yield('content')
        </div>
        @include('layouts._footer')
    </div>
    <!-- JS 脚本 -->
    <script src="{{ mix('js/app.js') }}"></script>
    @stack('pbl-js')
</body>
</html>