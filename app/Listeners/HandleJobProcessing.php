<?php

namespace App\Listeners;

use App\Models\JobHistory;
use Illuminate\Queue\Events\JobProcessing;

class HandleJobProcessing
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
    public function handle(JobProcessing $event)
    {
        // Job Status is Processing
        $job = $event->job;
        $uuid = $job->uuid();
        $payload = $job->payload();

        info("Job Processing UUID : ", [$uuid]);
        info("Job Processing Payload : ", [$payload]);

        JobHistory::updateOrCreate(
            [
                'uuid' => $uuid,
            ],
            [
                'uuid' => $uuid,
                'payload' => 'payload data',
                'status' => 'Processing',
            ]
        );
    }
}
