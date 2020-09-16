{{-- layoutsフォルダのapplication.blade.phpを継承 --}}
@extends('layouts.application')

{{-- @yield('title')にテンプレートごとの値を代入 --}}
@section('title', '新規作成')

    {{-- application.blade.phpの@yield('content')に以下のレイアウトを代入 --}}
@section('content')
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
            <input type="text" name="car_id" placeholder="号車番号を入れる">
        </div>
        <div>
            <label for="money">売上</label>
            <input type="text" name="money" placeholder="売上を入れる">
        </div>
        <div>
            <label for="date">日付</label>
            <input type="date" name="date" placeholder="日付を入れる">
        </div>
        <div>
            <label for="remarks">備考</label>
            <textarea name="remarks" rows="8" cols="80" placeholder="備考を入れる"></textarea>
        </div>

        <div>
            <input type="submit" value="送信">
        </div>
    </form>
@endsection
