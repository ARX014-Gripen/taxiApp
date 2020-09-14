{{-- layoutsフォルダのapplication.blade.phpを継承 --}}
@extends('layouts.application')

{{-- @yield('title')にテンプレートごとの値を代入 --}}
@section('title', '記事一覧')

    {{-- application.blade.phpの@yield('content')に以下のレイアウトを代入 --}}
@section('content')
    <div class="row">
        <div class="col s3">
            <div class="card">
                <div class="card-content">
                    <a href="/articles/create">日次売り上げ入力</a>
                </div>
            </div>
            <div class="card">
                <div class="card-content">
                    <a href="/home">ホーム画面に戻る</a>
                </div>
            </div>
        </div>

        <div class="col s9">
            @if ($articles->lastPage() > 1)

                @if ($articles->previousPageUrl())
                    <a href="{{ $articles->previousPageUrl() }}">前のページへ</a>
                @endif

                {{ $articles->currentPage() }} / {{ $articles->lastPage() }}

                @if ($articles->nextPageUrl())
                    <a href="{{ $articles->nextPageUrl() }}">次のページへ</a>
                @endif

            @endif
            @foreach ($articles as $article)
                <div class="card">
                    <div class="card-content">
                        <h4>{{ $article->title }}</h4>
                        <p>{{ $article->body }}</p>
                    </div>
                    <div class="card-tabs">
                        <ul class="tabs tabs-fixed-width">
                            <li class="tab"><a href="/articles/{{ $article->id }}">詳細を表示</a></li>
                            <li class="tab"><a href="/articles/{{ $article->id }}/edit">編集する</a></li>
                            {{-- <form action="/articles/{{ $article->id }}" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="delete">
                                <li class="tab"><input type="submit" name="" value="削除する"></li>
                            </form> --}}
                            <form action="{{ action('ArticlesController@destroy', $article->id) }}"
                                id="form_{{ $article->id }}" method="post" style="display:inline">
                                {{ csrf_field() }}
                                {{ method_field('delete') }}
                                <li class="tab"><a href="#" data-id="{{ $article->id }}" onclick="deletePost(this);"
                                        class="fs12">削除する</a></li>
                            </form>
                        </ul>
                    </div>
                </div>
            @endforeach

            {{-- <div class="chart-container" style="position: relative; width:80vw; height:50vh">
                <canvas id="allChart"></canvas>
            </div>


            <script src="{{ mix('js/show_chart.js') }}"></script>
            <script>
                id = 'allChart';
                labels = @json($keys);
                data = @json($counts);
                make_chart(id, labels, data);

            </script>
 --}}

        </div>
    </div>

    {{-- <div class="chart-container" style="position: relative; width:80vw; height:50vh">
        <canvas id="allChart"></canvas>
    </div>

    <script src="{{ mix('js/show_chart.js') }}"></script>
    <script>
        id = 'allChart';
        labels = @json($keys);
        data = @json($counts);
        make_chart(id, labels, data);

    </script>
    --}}
@endsection
<script>
    function deletePost(e) {
        'use strict';

        if (confirm('are you sure?')) {
            document.getElementById('form_' + e.dataset.id).submit();
        }
    }

</script>
