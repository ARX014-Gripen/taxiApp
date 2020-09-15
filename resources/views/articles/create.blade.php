{{-- layoutsフォルダのapplication.blade.phpを継承 --}}
@extends('layouts.application')

{{-- @yield('title')にテンプレートごとの値を代入 --}}
@section('title', '新規作成')

{{-- application.blade.phpの@yield('content')に以下のレイアウトを代入 --}}
@section('content')
  <form action="/articles" method="post">
    {{-- 以下を入れないとエラーになる --}}
    {{ csrf_field() }}
    <div>
      <label for="car_id">号車</label>
      <textarea name="car_id" rows="1" cols="80" placeholder="号車番号を入れる"></textarea>
    </div>
    <div>
      <label for="money">売上</label>
      <textarea name="money" rows="1" cols="80" placeholder="売上を入れる"></textarea>
    </div>
    <div>
      <label for="date">日付</label>
      <input type="date" name="date" placeholder="日付を入れる">
    </div>
    <div>
      <label for="remarks">備考</label>
      <input type="text" name="remarks" placeholder="備考を入れる">
    </div>
    <div>
      <input type="submit" value="送信">
    </div>
  </form>
@endsection