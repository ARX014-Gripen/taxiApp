{{-- layoutsフォルダのapplication.blade.phpを継承 --}}
@extends('layouts.application')

{{-- @yield('title')にテンプレートごとの値を代入 --}}
@section('title', '新規作成')

    {{-- application.blade.phpの@yield('content')に以下のレイアウトを代入 --}}
@section('content')
    <div class="row">
        <div class="col s9">
            <div class="card">
                <div class="card-content">
                    <form action="/articles" method="post">
                        {{-- 以下を入れないとエラーになる --}}
                        {{ csrf_field() }}
                        {{-- @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $message)
                                        <li>{{ $message }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif --}}
                        <div>
                            <label for="car_id">号車</label>
                            <input type="number" name="car_id" placeholder="号車番号を入れる">
                        </div>
                        <div>
                            <label for="money">売上</label>
                            <input type="number" name="money" placeholder="売上を入れる">
                        </div>
                        <div>
                            <label for="date">日付</label>
                            <input type="date" name="date" placeholder="日付を入れる">
                        </div>
                        <div>
                            <label for="remarks">備考</label>
                            <textarea name="remarks" rows="8" cols="80" placeholder="備考を入れる"></textarea>
                        </div>
                        <input type="hidden" type="text" name="Lat" id="Lat">
                        <input type="hidden" type="text" name="Lon" id="Lon">
                        <div>
                            <input type="submit" value="送信">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    window.onload = function() {
        // ページ読み込み時に実行したい処理
        // LatLon()
    }

    function LatLon() {
        navigator.geolocation.getCurrentPosition(deteil);
    }

    function deteil(position) {

        var geo_text = "緯度:" + position.coords.latitude + "\n";
        geo_text += "経度:" + position.coords.longitude + "\n";
        geo_text += "高度:" + position.coords.altitude + "\n";
        geo_text += "位置精度:" + position.coords.accuracy + "\n";
        geo_text += "高度精度:" + position.coords.altitudeAccuracy + "\n";
        geo_text += "移動方向:" + position.coords.heading + "\n";
        geo_text += "速度:" + position.coords.speed + "\n";

        var date = new Date(position.timestamp);

        geo_text += "取得時刻:" + date.toLocaleString() + "\n";

        alert(geo_text);

        document.getElementById("Lat").value = position.coords.latitude;
        document.getElementById("Lon").value = position.coords.longitude;
        alert(document.getElementById("Lat").value);
        alert(document.getElementById("Lon").value);

        document.myform.submit();

    }

</script>
