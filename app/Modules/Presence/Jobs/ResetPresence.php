<?php

namespace App\Modules\Presence\Jobs;

use App\Modules\Presence\Repository\PresenceRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ResetPresence implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $event;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($event)
    {
        $this->event = $event;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(PresenceRepositoryInterface $repo)
    {
        $eventId = $this->event;
        DB::beginTransaction();
        try {
            $deletedData = $repo->whereHas('guest', function ($query) use ($eventId) {
                $query->where('event_id', $eventId);
            })->pluck('id');
            foreach ($deletedData as $data) {
                $repo->delete($data);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }
}
