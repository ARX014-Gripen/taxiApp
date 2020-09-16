<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Requests\CreateTask;

// 以下を忘れずに。このコントローラーで使用したいモデルがあれば随時追加をしていくっぽい
use App\Article;
use App\Task;
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
        $tasks = Task::paginate(3);
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
        $task = new Task;
        $task->car_id = $request->car_id;
        $task->money = $request->money;
        $task->date = $request->date;
        $task->remarks = $request->remarks;
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
        // //
        // // 引数で受け取った$idを元にfindでレコードを取得
        // $article = Article::find($id);
        // // viewにデータを渡す  
        // return view('articles.show', ['article' => $article]);
        
        $task = Task::find($id);
        // viewにデータを渡す  
        return view('articles.show', ['task' => $task]);
        
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
        $article = Article::find($id);
        // editで編集されたデータを$articleにそれぞれ代入する
        $article->title = $request->title;
        $article->body = $request->body;
        // 保存
        $article->save();
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
        $article = Article::find($id);
        // 削除
        $article->delete();
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
        $task = Task::query();
        $task->whereDate('date', '2020-09-14');
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

        return view('home', ['keys'=>$keys,'counts'=>$counts,'tasks'=>$tasks ]);      
    }

}
