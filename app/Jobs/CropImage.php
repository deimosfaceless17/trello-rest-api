<?php

namespace App\Jobs;

use App\Models\Image as ImageModel;
use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\UploadedFile;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Intervention\Image\Image;

//todo maybe it must be 2 jobs, and run in chain, or DI here ImageService
class CropImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string
     */
    public string $path;

    /**
     * @var string
     */
    public string $name;

    /**
     * @var int $taskId
     */
    public int $taskId;

    /**
     * @var int $userId
     */
    public int $userId;

    /**
     * CropImage constructor.
     *
     * @param string $path
     * @param string $name
     * @param int $taskId
     * @param int $userId
     */
    public function __construct(string $path, string $name, int $taskId, int $userId)
    {
        $this->path = $path;
        $this->name = $name;
        $this->taskId = $taskId;
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Intervention\Image\Facades\Image::make($this->path)->resize(300, 200)->save('mobile/' . $this->userId . $this->name);

        $mobileImageModel = new ImageModel([
            'image_url' => 'mobile/' . $this->userId . $this->name
        ]);
        $mobileImageModel->save();

        \Intervention\Image\Facades\Image::make($this->path)->save('desktop/' . $this->userId . $this->name);

        $desktopImageModel = new ImageModel([
            'image_url' => 'desktop/' . $this->userId . $this->name
        ]);
        $desktopImageModel->save();

        $task = Task::findOrFail($this->taskId);
        $task->desktop_image_id = $desktopImageModel->id;
        $task->mobile_image_id = $mobileImageModel->id;
        $task->update();
    }
}
