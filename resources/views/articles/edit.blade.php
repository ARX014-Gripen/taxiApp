{{-- layoutsフォルダのapplication.blade.phpを継承 --}}
@extends('layouts.application')

{{-- @yield('title')にテンプレートごとの値を代入 --}}
@section('title', '編集')

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
                    <form action="/articles/{{ $task->id }}" method="post">
                        {{ csrf_field() }}
                        <div>
                            <label for="car_id">号車</label>
                            <input type="number" name="car_id" placeholder="車両番号を入れる" value="{{ old('car_id') ?? $task->car_id }}">
                        </div>
                        <div>
                            <label for="money">売上</label>
                            <input type="number" name="money" placeholder="売上を入れる" value="{{ old('money') ?? $task->money }}">
                        </div>
                        <div>
                            <label for="date">日付</label>
                            <input type="date" name="date" placeholder="日付を入れる" value="{{ old('date') ?? $task->date }}">
                        </div>
                        <div>
                            <label for="origin">出発地点</label>
                            <input id="origin" name="origin" placeholder="出発地点を入れてください" value="{{ old('origin') ?? $task->origin }}">
                        </div>
                        <div>
                            <label for="destination">到着地点</label>
                            <input id="destination" name="destination" placeholder="到着地点を入れてください" value="{{ old('destination') ?? $task->destination }}">
                        </div>
                        <div>
                            <label for="remarks">備考を入れる</label>
                            <textarea name="remarks" rows="8" cols="80" placeholder="備考を入れる">{{ old('remarks') ?? $task->remarks }}</textarea>
                        </div>
                        <div>
                            <input type="hidden" name="_method" value="patch">
                            <input type="submit" value="更新">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
