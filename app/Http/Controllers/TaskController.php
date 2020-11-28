<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\Task\CreateRequest;
use App\Http\Resources\Task as TaskResource;
use App\Http\Resources\Tasks;
use App\Jobs\CropImage;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Auth::user()->tasks()->with(['mobileImage', 'desktopImage']);

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

        if ($request->has('image')) {
            CropImage::dispatch($request->image->getRealPath(), $request->image->getClientOriginalName(), $task->id, $user->id)
                ->onQueue('images')
            ;
        }

        return new TaskResource($task);
    }
}
