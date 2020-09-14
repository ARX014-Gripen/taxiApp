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
                    <a href="/articles/create">新規作成</a>
                </div>
            </div>
            <div class="card">
                <div class="card-content">
                    <a href="/articles/create">日次売り上げ入力</a>
                </div>
            </div>
            <div class="card">
                <div class="card-content">
                    <a href="/articles/create">ホーム画面に戻る</a>
                </div>
            </div>
        </div>

        <div class="col s9">

            <div class="chart-container" style="position: relative; width:80vw; height:50vh">
                <canvas id="allChart"></canvas>
            </div>


            <script src="{{ mix('js/show_chart.js') }}"></script>
            <script>
                id = 'allChart';
                labels = @json($keys);
                data = @json($counts);
                make_chart(id, labels, data);

            </script>


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
