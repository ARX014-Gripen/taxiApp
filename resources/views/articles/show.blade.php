{{-- layoutsフォルダのapplication.blade.phpを継承 --}}
@extends('layouts.application')

{{-- @yield('title')にテンプレートごとの値を代入 --}}
@section('title', '記事詳細')

    {{-- application.blade.phpの@yield('content')に以下のレイアウトを代入 --}}
@section('content')
    <p>{{ $task->car_id }}</p>
    <p>{{ $task->money }}</p>
    <p>{{ $task->date }}</p>
    <p>{{ $task->remarks }}</p>
    <br><br>
    <a href="/articles/{{ $task->id }}/edit">編集する</a>
    <form action="{{ action('ArticlesController@destroy', $task->id) }}" id="form_{{ $task->id }}" method="post"
        style="display:inline">
        {{ csrf_field() }}
        {{ method_field('delete') }}
        <li class="tab"><a href="#" data-id="{{ $task->id }}" onclick="deletePost(this);" class="fs12">削除する</a></li>
    </form>
    <a href="/articles">一覧に戻る</a>
@endsection
<script>
  function deletePost(e) {
      'use strict';

      if (confirm('are you sure?')) {
          document.getElementById('form_' + e.dataset.id).submit();
      }
  }

</script>
