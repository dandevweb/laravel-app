<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();

        return response($tasks);
    }

    public function show(Task $task)
    {
        return response($task);
    }

    public function store(Request $request)
    {
        return Task::create($request->all());
    }

    public function update(Request $request, Task $task)
    {
        $task->update($request->all());

        return response($task);
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
