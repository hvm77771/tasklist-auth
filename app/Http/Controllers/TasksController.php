<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;    // 追加



class TasksController extends Controller
{
    
    
    public function index()
    {
        $tasks = Task::all();

        return view('tasks.index', [
            'tasks' => $tasks,
        ]);
    
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $task = new Task;

        return view('tasks.create', [
            'task' => $task,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
        'status' => 'required|max:10',   // 追加
        'content' => 'required|max:191',
        ]);
        
        $task = new Task;
        $task->user_id = $request->user()->id;
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();

        return redirect('/tasks');
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
        if (\Auth::id() === $task->user_id) {
        return view('tasks.show', [
            'task' => $task,
        ]);
        }
        return redirect('/tasks');
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::find($id);
        if (\Auth::id() === $task->user_id) {
        return view('tasks.edit', [
            'task' => $task,
        ]);
        }
        return redirect('/tasks');
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
        
        $this->validate($request, [
         'status' => 'required|max:10',
         'content' => 'required|max:191',
        ]);
        
        $task = Task::find($id);
        if (\Auth::id() === $task->user_id) {
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();
        }
        return redirect('/tasks');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        if (\Auth::id() === $task->user_id) {
        $task->delete();
        }
        return redirect('/tasks');

    }
}
