{{-- layoutsフォルダのapplication.blade.phpを継承 --}}
@extends('layouts.application')

{{-- @yield('title')にテンプレートごとの値を代入 --}}
@section('title', '記事一覧')

@section('content')
    <div class="row">
        <div class="col s3">
            <div class="card">
                <div class="card-content">
                    <a href="/articles/create">日次売上入力</a>
                </div>
            </div>
            <div class="card">
                <div class="card-content">
                    <a href="/home">ホーム画面に戻る</a>
                </div>
            </div>
        </div>
        <div class="col s9">
            @if ($tasks->lastPage() > 1)
                @if ($tasks->previousPageUrl())
                    <a href="{{ $tasks->previousPageUrl() }}">前のページへ</a>
                @endif
                {{ $tasks->currentPage() }} / {{ $tasks->lastPage() }}
                @if ($tasks->nextPageUrl())
                    <a href="{{ $tasks->nextPageUrl() }}">次のページへ</a>
                @endif
            @endif
            @foreach ($tasks as $task)
                <div class="card">
                    <div class="card-content">
                        <h4>{{ $task->car_id }}号車</h4>
                        <p>{{ $task->date }}　{{ $task->money }}円</p>
                        <p></p>
                    </div>
                    <div class="card-tabs">
                        <ul class="tabs tabs-fixed-width">
                            <li class="tab"><a href="/articles/{{ $task->id }}">詳細を表示</a></li>
                            <li class="tab"><a href="/articles/{{ $task->id }}/edit">編集する</a></li>
                            <form action="{{ action('ArticlesController@destroy', $task->id) }}" id="form_{{ $task->id }}"
                                method="post" style="display:inline">
                                {{ csrf_field() }}
                                {{ method_field('delete') }}
                                <li class="tab"><a href="#" data-id="{{ $task->id }}" onclick="deletePost(this);"
                                        class="fs12">削除する</a></li>
                            </form>
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
<script>
    function deletePost(e) {
        'use strict';

        if (confirm('are you sure?')) {
            document.getElementById('form_' + e.dataset.id).submit();
        }
    }

</script>
