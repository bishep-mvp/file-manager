<?php

namespace App\Jobs;

use App\Models\File;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UploadFileToCloudJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected File $file) {}

    /**
     * Execute the job.
     */
    public function handle(): void
{
    $model = $this->file;

    if (!$model->uploaded_on_cloud) {
        $localPath = Storage::disk('local')->path($model->storage_path);
        Log::info("Файл для загрузки: " . $localPath);

        try {
            $success = Storage::put($model->storage_path, Storage::disk('local')->get($model->storage_path));

            if ($success) {
                Log::info("Файл успешно загружен");
                $model->uploaded_on_cloud = 1;
                $model->saveQuietly();
            } else {
                Log::error("Не удалось загрузить файл на Ya.");
            }
        } catch (\Exception $e) {
            Log::error("Ошибка при загрузке файла: " . $e->getMessage());
        }
    }
}

}
