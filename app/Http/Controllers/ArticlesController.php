<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateTask;
use App\Http\Requests\UpdateTask;

use \SplFileObject;

// 以下を忘れずに。このコントローラーで使用したいモデルがあれば随時追加をしていくっぽい
use App\Article;
use App\Task;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $task = Task::query();
        $task->orderBy('date', 'DESC');
        $task->orderBy('created_at', 'DESC');
        $tasks = $task->paginate(3);
        return view('articles.index', ['tasks' => $tasks]);    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    public function store(CreateTask $request)
    {

        $dateTime = new Carbon(date("Y-m-d H:i:s"));
        // データ登録
        $task = new Task;
        $task->car_id = $request->car_id;
        $task->money = $request->money;
        $task->date = $request->date;
        $task->remarks = $request->remarks;
        $task->created_at = $dateTime->addHours(9);
        $task->origin = $request->origin;
        $task->destination = $request->destination;
        $task->save();
        
        return redirect('/articles');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // 選択された日時の車両売上詳細を取得
        $task = Task::find($id);

        // 降車位置
        $url = "https://www.google.com/maps/dir/?api=1&origin=";
        $url .= $task->origin;
        $url .= "&destination=";
        $url .= $task->destination;
        $url .= "&travelmode=driving";

        // 選択された車両の日次売上を時系列に取得
        $taskl = Task::query();
        $taskl->whereDate('date', $task->date);
        $taskl = $taskl->where('car_id',$task->car_id);
        $taskl->orderBy('created_at', 'ASC');
        $tasks=$taskl->get();

        // 線グラフ用データへパッキング
        $keys = [];
        $counts = [];
        foreach ($tasks as $taskl) {
            array_push($keys, $taskl->created_at->format('H:i:s'));
            array_push($counts, $taskl->money);
        }

        // 画面呼び出しとデータの受け渡し
        return view('articles.show', ['task' => $task,'counts' => $counts,'keys' => $keys,'url' => $url]);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $task = Task::find($id);
        return view('articles.edit', ['task' => $task]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id)
    public function update(UpdateTask $request, $id)
    {
        //
        // idを元にレコードを検索して$articleに代入
        $task = Task::find($id);

        $task->car_id = $request->car_id;
        $task->money = $request->money;
        $task->date = $request->date;
        $task->remarks = $request->remarks;
        $task->save();

        // 詳細ページへリダイレクト
        return redirect("/articles/".$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        // idを元にレコードを検索
        $task = Task::find($id);
        // 削除
        $task->delete();
        // 一覧にリダイレクト
        return redirect('/articles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function day()
    {
        // 現在時刻を日本時間に設定
        $dateTime = new Carbon(date("Y-m-d H:i:s"));
        $dateTime = $dateTime->addHours(9);

        // 車両ごとの日次売上を降順で取得
        $task = Task::query();
        $task->whereDate('date', $dateTime->format("Y-m-d"));
        $task->select('car_id', DB::raw('SUM(money) as total'));
        $task->groupBy('car_id');
        $task->orderBy('total', 'DESC');
        $tasks=$task->get();

        // 円グラフ用データへパッキング
        $keys = [];
        $counts = [];
        foreach ($tasks as $task) {
            array_push($keys, "{$task->car_id}号車");
            array_push($counts, $task->total);
        }

        // 画面呼び出しとデータの受け渡し
        return view('home', ['keys'=>$keys,'counts'=>$counts,'date'=>$dateTime,'url'=>'/week']);      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function week()
    {
        // 現在時刻を日本時間に設定
        $dateTime = new Carbon(date("Y-m-d H:i:s"));
        $dateTime = $dateTime->addHours(9);

        //週初め
        $date = clone $dateTime;
        $startDate = clone $date->startOfWeek();
        //週終わり
        $endDate  = clone $date->endOfWeek();
        
        // 車両ごとの週次売上を降順で取得
        $task = Task::query();
        $task->whereBetween('date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')]);
        $task->select('car_id', DB::raw('SUM(money) as total'));
        $task->groupBy('car_id');
        $task->orderBy('total', 'DESC');
        $tasks=$task->get();

        // 円グラフ用データへパッキング
        $keys = [];
        $counts = [];
        foreach ($tasks as $task) {
            array_push($keys, "{$task->car_id}号車");
            array_push($counts, $task->total);
        }

        // 画面呼び出しとデータの受け渡し
        return view('home', ['keys'=>$keys,'counts'=>$counts,'date'=>$dateTime,'url'=>'/month']);      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function month()
    {
        // 現在時刻を日本時間に設定
        $dateTime = new Carbon(date("Y-m-d H:i:s"));
        $dateTime = $dateTime->addHours(9);

        //指定の年月
        $Month = $dateTime->format("Y-m");
        //月初め
        $startDate = new Carbon('first day of ' . $Month);
        //月終わり
        $endDate  = new Carbon('last day of ' . $Month);
        
        // 車両ごとの月次売上を降順で取得
        $task = Task::query();
        $task->whereBetween('date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')]);
        $task->select('car_id', DB::raw('SUM(money) as total'));
        $task->groupBy('car_id');
        $task->orderBy('total', 'DESC');
        $tasks=$task->get();

        // 円グラフ用データへパッキング
        $keys = [];
        $counts = [];
        foreach ($tasks as $task) {
            array_push($keys, "{$task->car_id}号車");
            array_push($counts, $task->total);
        }

        // 画面呼び出しとデータの受け渡し
        return view('home', ['keys'=>$keys,'counts'=>$counts,'date'=>$dateTime,'url'=>'/year']);      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function year()
    {
        // 現在時刻を日本時間に設定
        $dateTime = new Carbon(date("Y-m-d H:i:s"));
        $dateTime = $dateTime->addHours(9);

        //指定の年月
        $Year = $dateTime->format("Y");
        //年初め
        $startDate = $Year;
        $startDate .= "-01-01";
        //年終わり
        $endDate = $Year;
        $endDate .= "-12-31";
        
        // 車両ごとの年次売上を降順で取得
        $task = Task::query();
        $task->whereBetween('date', [$startDate, $endDate]);
        $task->select('car_id', DB::raw('SUM(money) as total'));
        $task->groupBy('car_id');
        $task->orderBy('total', 'DESC');
        $tasks=$task->get();

        // 円グラフ用データへパッキング
        $keys = [];
        $counts = [];
        foreach ($tasks as $task) {
            array_push($keys, "{$task->car_id}号車");
            array_push($counts, $task->total);
        }

        // 画面呼び出しとデータの受け渡し
        return view('home', ['keys'=>$keys,'counts'=>$counts,'date'=>$dateTime,'url'=>'/day']);      
    }
}
