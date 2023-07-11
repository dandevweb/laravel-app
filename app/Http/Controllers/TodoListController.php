<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoListRequest;
use App\Models\TodoList;
use Symfony\Component\HttpFoundation\Response;

class TodoListController extends Controller
{
    public function index()
    {
        $lists = TodoList::all();

        return response([$lists]);
    }

    public function show(TodoList $todoList)
    {
        return response($todoList);
    }

    public function store(TodoListRequest $request)
    {
        return TodoList::create($request->all());
    }

    public function destroy(TodoList $todoList)
    {
        $todoList->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function update(TodoListRequest $request, TodoList $todoList)
    {
        $todoList->update($request->all());

        return response($todoList);
    }
}
