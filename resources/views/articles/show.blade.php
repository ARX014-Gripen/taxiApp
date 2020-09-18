{{-- layoutsフォルダのapplication.blade.phpを継承 --}}
@extends('layouts.application')

@section('head')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css">
    <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"></script>
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
                    <p>備考：{{ $task->remarks }}</p>
                    {{-- <p><a href={{ $url }}>降車位置表示</a></p>
                    {{ $url }} --}}
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
    <div id="map" style="position: relative; width:80vw; height:50vh"></div>
    <br>
@endsection
<script>
    window.onload = function() {
        // ページ読み込み時に実行したい処理
        // 地図を作成する
        var mymap = L.map('map');

        // タイルレイヤーを作成し、地図にセットする
        L.tileLayer('https://cyberjapandata.gsi.go.jp/xyz/std/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '© OpenStreetMap contributors, CC-BY-SA <a href="https://maps.gsi.go.jp/development/ichiran.html" target="_blank">国土地理院</a>',
        }).addTo(mymap);

        // 地図の中心座標とズームレベルを設定する
        mymap.setView([@json($task->Lat), @json($task->Lon)], 13);
       
        // マーカを置く
        L.marker([37.508106, 139.930239]).addTo(mymap);
    }

    function deletePost(e) {
        'use strict';

        if (confirm('are you sure?')) {
            document.getElementById('form_' + e.dataset.id).submit();
        }
    }

</script>
