<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Requests\CreateTask;

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
    public function store(Request $request)
    // public function store(CreateTask $request)
    {

        $dateTime = new Carbon(date("Y-m-d H:i:s"));

        $task = new Task;
        $task->car_id = $request->car_id;
        $task->money = $request->money;
        $task->date = $request->date;
        $task->remarks = $request->remarks;
        $task->created_at = $dateTime->addHours(9);
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
        $task = Task::find($id);

        $taskl = Task::query();
        $taskl->whereDate('date', $task->date);
        $taskl = $taskl->where('car_id',$task->car_id);
        $taskl->orderBy('created_at', 'ASC');
        $tasks=$taskl->get();

        $keys = [];
        $counts = [];
        foreach ($tasks as $taskl) {
            array_push($keys, $taskl->created_at->format('H:i:s'));
            array_push($counts, $taskl->money);
        }

        // viewにデータを渡す  
        return view('articles.show', ['task' => $task,'counts' => $counts,'keys' => $keys]);
        
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
    public function update(Request $request, $id)
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
    public function home()
    {
        $dateTime = new Carbon(date("Y-m-d H:i:s"));
        $dateTime = $dateTime->addHours(9);
        $task = Task::query();
        $task->whereDate('date', $dateTime->format("Y-m-d"));
        $task->select('car_id', DB::raw('SUM(money) as total'));
        $task->groupBy('car_id');
        $task->orderBy('total', 'DESC');
        $tasks=$task->get();

        $keys = [];
        $counts = [];
        foreach ($tasks as $task) {
            array_push($keys, "{$task->car_id}号車");
            array_push($counts, $task->total);
        }

        return view('home', ['keys'=>$keys,'counts'=>$counts,'date'=>$dateTime]);      
    }

}
