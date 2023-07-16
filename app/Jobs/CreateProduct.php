<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateProduct implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $data;

    public function __construct($request)
    {
        $this->data = $request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // info("CreateProduct Job :");
        // info("Job UUID : ", [$this->job->uuid()]);
        // info("Job Payload : ", [$this->job->payload()]);

        Product::create([
            'name' => $this->data['name'],
            'description' => $this->data['description'],
            'price' => $this->data['price'],
            'status' => $this->data['status'],
        ]);
    }
}
