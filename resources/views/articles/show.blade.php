{{-- layoutsフォルダのapplication.blade.phpを継承 --}}
@extends('layouts.application')

@section('head')
@endsection

{{-- @yield('title')にテンプレートごとの値を代入 --}}
@section('title', '日次売上詳細')

    {{-- application.blade.phpの@yield('content')に以下のレイアウトを代入 --}}
@section('content')
    <div class="row">
        <div class="col s9">
            <div class="card">
                <div class="card-content">
                    <p>{{ $task->car_id }}号車</p>
                    <p>{{ $task->money }}円</p>
                    <p>{{ $task->date }}</p>
                    <p>出発地点：{{ $task->origin }}</p>
                    <p>到着地点：{{ $task->destination }}</p>
                    <p>備考：{{ $task->remarks }}</p>
                    <p><a href={{$url}}>ルート再検索</a></p>
                </div>
                <div class="card-tabs">
                    <ul class="tabs tabs-fixed-width">

                        <li class="tab"><a href="/articles/{{ $task->id }}/edit">編集する</a></li>
                        <form action="{{ action('ArticlesController@destroy', $task->id) }}" id="form_{{ $task->id }}"
                            method="post" style="display:inline">
                            {{ csrf_field() }}
                            {{ method_field('delete') }}
                            <li class="tab"><a href="#" data-id="{{ $task->id }}" onclick="deletePost(this);"
                                    class="fs12">削除する</a>
                            </li>
                        </form>
                        <li class="tab"><a href="/articles">一覧に戻る</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col s9">
            <div class="chart-container" style="position: relative; width:80vw; height:50vh">
                <canvas id="allChart"></canvas>
            </div>
            <script src="{{ mix('js/show_line_chart.js') }}"></script>
            <script>
                id = 'allChart';
                labels = @json($keys);
                data = @json($counts);
                make_chart(id, labels, data);
            </script>
        </div>
    </div>
    <br>
@endsection
<script>
    function deletePost(e) {
        'use strict';

        if (confirm('削除しますか?')) {
            document.getElementById('form_' + e.dataset.id).submit();
        }
    }
</script>
