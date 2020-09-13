{{-- layoutsフォルダのapplication.blade.phpを継承 --}}
@extends('layouts.application')

{{-- @yield('title')にテンプレートごとの値を代入 --}}
@section('title', '記事一覧')

{{-- application.blade.phpの@yield('content')に以下のレイアウトを代入 --}}
@section('content')
  <div>
    <a href="/articles/create">新規作成</a>
  </div>
  @foreach ($articles as $article)
    {{-- <h4>{{$article->title}}</h4>
    <p>{{$article->body}}</p>
    <a href="/articles/{{$article->id}}">詳細を表示</a>
    <a href="/articles/{{$article->id}}/edit">編集する</a>
    <form action="/articles/{{$article->id}}" method="post">
      {{ csrf_field() }}
      <input type="hidden" name="_method" value="delete">
      <input type="submit" name="" value="削除する">
    </form> --}}
    {{-- <a href="/articles/{{$article->id}}">削除する</a> --}}
    {{-- <hr> --}}

    <div class="card">
      <div class="card-content">
        <h4>{{$article->title}}</h4>
        <p>{{$article->body}}</p>
      </div>
      <div class="card-tabs">
        <ul class="tabs tabs-fixed-width">
          <li class="tab"><a href="/articles/{{$article->id}}">詳細を表示</a></li>
          <li class="tab"><a href="/articles/{{$article->id}}/edit">編集する</a></li>
          {{-- <form action="/articles/{{$article->id}}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="delete">
            <li class="tab"><input type="submit" name="" value="削除する"></li>
          </form> --}}
          <form action="{{ action('ArticlesController@destroy', $article->id) }}" id="form_{{ $article->id }}" method="post" style="display:inline">
            {{ csrf_field() }}
            {{ method_field('delete') }}
            <li class="tab"><a href="#" data-id="{{ $article->id }}" onclick="deletePost(this);" class="fs12">削除する</a></li>
          </form>
        </ul>
      </div>
    </div>
  @endforeach

  @if($articles->lastPage() > 1)

  @if($articles->previousPageUrl())
      <a href="{{ $articles->previousPageUrl() }}">前のページへ</a>
  @endif

  {{ $articles->currentPage() }} / {{ $articles->lastPage() }}

  @if($articles->nextPageUrl())
      <a href="{{ $articles->nextPageUrl() }}">次のページへ</a>
  @endif

@endif
@endsection
<script>
  function deletePost(e) {
    'use strict';
  
    if (confirm('are you sure?')) {
      document.getElementById('form_' + e.dataset.id).submit();
    }
  }
</script>
