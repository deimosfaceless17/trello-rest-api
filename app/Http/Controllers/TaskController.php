<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\Task\CreateRequest;
use App\Http\Resources\Task as TaskResource;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function create(CreateRequest $request)
    {
        $user = Auth::user();

        $task = $user->tasks()->create($request->all());

        return new TaskResource($task);
    }
}
