<?php

namespace App\Listeners;

use App\Models\JobHistory;
use Illuminate\Queue\Events\JobFailed;

class HandleJobFailed
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
    public function handle(JobFailed $event)
    {
        // Job Status is Failed
        $job = $event->job;
        $uuid = $job->uuid();
        $payload = $job->payload();
        $exception = $event->exception->getMessage();

        info("Job Failed UUID : ", [$uuid]);
        info("Job Failed Payload: ", [$payload]);
        info("Job Failed Exception: ", [$exception]);

        JobHistory::where('uuid', $uuid)->update(['exception' => $exception, 'failed_at' => now(), 'status' => 'Failed']);
    }
}
