<?php

namespace App\Modules\EventParticipant\Jobs;

use App\Modules\EventParticipant\EventParticipant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProccessThumbnail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $imagePath;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($imagePath)
    {
        $this->imagePath = $imagePath;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $path = public_path('storage/' . $this->imagePath);
        $image = \Image::make($path);
        $image->resize(250, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $image->save($path, 60);
    }
}
