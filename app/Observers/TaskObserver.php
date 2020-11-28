<?php

namespace App\Observers;

use App\Models\Task;
use App\Models\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TaskObserver
{
    public function created(Task $task)
    {
        $this->saveLog($task, 'insert');
    }

    public function updated(Task $task)
    {
        $this->saveLog($task,'update');
    }

    public function deleted(Task $task)
    {
        $arChange = [];

        foreach ($task->getOriginal() as $key => $value) {
            $arChange[$key] = [
                'old' => $value,
                'new' => null,
            ];
        }

        $log = $this->createLog($arChange, $task->getTable(), 'delete');
        $log->record_id = $task->id;

        try {
            $log->save();
        } catch (\Throwable $e) {
            // TODO: message to developers
            throw $e;
        }
    }

    /**
     * @param Task $task
     * @param string $operation
     *
     * @throws \Throwable
     */
    private function saveLog(Task $task, string $operation)
    {
        $arChange = [];

        if ($task->exists) {
            $dirty = $task->getDirty();

            if (count($dirty) > 0) {
                foreach ($dirty as $key => $value) {
                    if ($task->getOriginal($key) != $value) {
                        $arChange[$key] = [
                            'old' => $task->getOriginal($key),
                            'new' => $value,
                        ];
                    }
                }
            }
        } else {
            foreach ($task->attributes as $key => $value) {
                $arChange[$key] = [
                    'old' => null,
                    'new' => $value,
                ];
            }
        }

        if (!empty($arChange)) {
            $log = $this->createLog($arChange, $task->getTable(), $operation);

            $log->record_id = $task->id;

            try {
                $log->save();
            } catch (\Throwable $e) {
                // TODO: message to developers
                throw $e;
            }
        }
    }

    /**
     * Create log without saving
     *
     * @param array $arChange
     * @param string $table
     * @param string $operation
     *
     * @return Log
     * @throws \Exception
     */
    private function createLog(array $arChange, string $table, string $operation)
    {
        $log = new Log();
        $log->user_id = Auth::user() ? Auth::user()->id : null;
        $log->date_time = (new Carbon())->format('Y-m-d H:i:s');
        $log->table_name = $table;
        $log->modifications = $arChange;
        $log->operation = $operation;

        return $log;
    }
}
