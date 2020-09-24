<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
  @yield('head')
  <title>@yield('title')</title>
</head>
<body>
  <div class="card-panel teal lighten-2">各タクシー売上チェックアプリ</div>
  @yield('content')
</body>
</html>
@yield('script')
