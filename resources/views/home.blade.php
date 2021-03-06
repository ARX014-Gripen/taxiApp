{{-- layoutsフォルダのapplication.blade.phpを継承 --}}
@extends('layouts.application')

{{-- @yield('title')にテンプレートごとの値を代入 --}}
@section('title', 'ホーム')

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
                    <a href="/articles">売上一覧</a>
                </div>
            </div>
        </div>
        <div class="col s9">
            @if ($url === '/week')
                <a href={{ $url }}>週次全体売上に切り替え</a>
            @elseif ($url === '/month')
                <a href={{ $url }}>月次全体売上に切り替え</a>
            @elseif ($url === '/year')
                <a href={{ $url }}>年次全体売上に切り替え</a>
            @elseif ($url === '/day')
                <a href={{ $url }}>日次全体売上に切り替え</a>
            @endif
            <div class="chart-container" style="position: relative; width:70vw; height:50vh">
                <canvas id="allChart"></canvas>
            </div>
            <script src="{{ mix('js/show_pie_chart.js') }}"></script>
            <script>
                id = 'allChart';
                labels = @json($keys);
                data = @json($counts);
                make_chart(id, labels, data);

            </script>
            @if ($url === '/week')
                日次全体売上
            @elseif ($url === '/month')
                週次全体売上
            @elseif ($url === '/year')
                月次全体売上
            @elseif ($url === '/day')
                年次全体売上
            @endif
            {{ $date }}
        </div>
    </div>
@endsection
@section('script')
    <script>
    </script>
@endsection
