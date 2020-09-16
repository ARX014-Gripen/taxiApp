{{-- layoutsフォルダのapplication.blade.phpを継承 --}}
@extends('layouts.application')

{{-- @yield('title')にテンプレートごとの値を代入 --}}
@section('title', '編集')

{{-- application.blade.phpの@yield('content')に以下のレイアウトを代入 --}}
@section('content')
  <form action="/articles/{{$task->id}}" method="post">
    {{ csrf_field() }}
    <div>
      <label for="car_id">号車</label>
      <input type="text" name="car_id" placeholder="車両番号を入れる" value="{{$task->car_id}}">
    </div>
    <div>
      <label for="money">売上</label>
      <input type="text" name="money" placeholder="売上を入れる" value="{{$task->money}}">
    </div>
    <div>
      <label for="date">日付</label>
      <input type="date" name="date" placeholder="日付を入れる" value="{{$task->date}}">
    </div>
    <div>
      <label for="remarks">備考を入れる</label>
      <textarea name="remarks" rows="8" cols="80" placeholder="備考を入れる">{{$task->remarks}}</textarea>
    </div>
    <div>
      <input type="hidden" name="_method" value="patch">
      <input type="submit" value="更新">
    </div>
  </form>
@endsection