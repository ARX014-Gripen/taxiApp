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
                    @if ($errors->any())
                        <div>
                            <ul>
                                @foreach ($errors->all() as $message)
                                    <li>{{ $message }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="/articles" method="post" onsubmit="return preSubmit();">
                        {{-- 以下を入れないとエラーになる --}}
                        {{ csrf_field() }}
                        <div>
                            <label for="car_id">号車</label>
                            <input id="car_id" type="number" name="car_id" placeholder="号車番号を入れる">
                        </div>
                        <div>
                            <label for="date">日付</label>
                            <input id="date" type="date" name="date" placeholder="日付を入れる">
                        </div>
                        <div>
                            <label for="origin">出発地点</label>
                            <input id="origin" name="origin" placeholder="出発地点を入れてください">
                        </div>
                        <div>
                            <label for="destination">到着地点</label>
                            <input id="destination" name="destination" placeholder="到着地点を入れてください">
                        </div>
                        <div>
                            <label for="money">売上</label>
                            <input id="money" type="number" name="money" placeholder="売上を入れる">
                        </div>
                        <div>
                            <label for="remarks">備考</label>
                            <textarea name="remarks" rows="8" cols="80" placeholder="備考を入れる"></textarea>
                        </div>
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
    function preSubmit() {
        var car_id = document.getElementById("car_id").value
        var date = document.getElementById("date").value
        var origin = document.getElementById("origin").value
        var destination = document.getElementById("destination").value
        var money = document.getElementById("money").value
        if ( !(!origin && !destination && !car_id && !date)) {
            var url = "https://www.google.com/maps/dir/?api=1&origin=";
            url += origin;
            url += "&destination=";
            url += destination;
            url += "&travelmode=driving";
            window.open(url);
        }
        return
    }

</script>
