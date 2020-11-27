<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\Task\CreateRequest;
use App\Http\Resources\Task as TaskResource;
use App\Http\Resources\Tasks;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Auth::user()->tasks();

        $statuses = request()->get('statuses');
        if ($statuses) {
            $statuses = explode(',', $statuses);
            $statuses = array_intersect($statuses, Task::STATUSES);

            $tasks = $tasks->whereIn('status', $statuses);
        }

        return new Tasks($tasks->paginate());
    }

    public function create(CreateRequest $request)
    {
        $user = Auth::user();

        $task = $user->tasks()->create($request->all());

        return new TaskResource($task);
    }
}
