<?php

namespace App\Listeners;

use App\Models\JobHistory;
use Illuminate\Queue\Events\JobProcessed;

class HandleJobProcessed
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(JobProcessed $event)
    {
        // Job Status is Completed
        $job = $event->job;
        $uuid = $job->uuid();
        $payload = $job->payload();

        info("Job Processed UUID : ", [$uuid]);
        info("Job Processed Payload : ", [$payload]);

        JobHistory::where('uuid', $uuid)->update(['status' => 'Completed', 'processed_at' => now()]);
    }
}
