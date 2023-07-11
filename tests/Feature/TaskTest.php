<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_fetch_all_tasks_of_a_todo_list()
    {
        $list = $this->createTodoList();
        $task = $this->createTask(['todo_list_id' => $list->id]);
        $this->createTask(['todo_list_id' => 2]);

        $response = $this->getJson(route('todo-list.task.index', $list->id))->assertOk()->json();

        $this->assertEquals(1, count($response));
        $this->assertEquals($task->title, $response[0]['title']);
        $this->assertEquals($task->todo_list_id, $response[0]['todo_list_id']);
    }

    public function test_store_task_for_a_todo_list()
    {
        $list = $this->createTodoList();
        $task = $this->createTask();

        $this->postJson(route('todo-list.task.store', $list->id), ['title' => $task->title])
            ->assertCreated();

        $this->assertDatabaseHas(Task::class, ['title' => $task->title]);
    }

    public function test_delete_a_task_from_database()
    {
        $list = $this->createTodoList();
        $task = $this->createTask(['todo_list_id' => $list->id]);

        $this->deleteJson(route('task.destroy', $task->id));

        $this->assertDatabaseMissing(Task::class, ['title' => $task->title]);
    }

    public function test_update_a_task_of_a_todo_list()
    {
        $list = $this->createTodoList();
        $task = $this->createTask();

        $this->putJson(route('task.update', $task->id), ['title' => 'updated task'])
            ->assertOk();

        $this->assertDatabaseHas(Task::class, [
            'title' => 'updated task',
        ]);
    }
}
