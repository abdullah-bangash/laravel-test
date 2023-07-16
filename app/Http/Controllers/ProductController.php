<?php

namespace App\Http\Controllers;

use App\Jobs\CreateProduct;
use App\Models\JobHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $requestData = $request->all();
        // dispatch(new CreateProduct($requestData));
        dispatch(new CreateProduct($requestData));
        $pendingJob = DB::table('jobs')
            ->where('queue', 'default')
            ->orderBy('id', 'desc')
            ->first('payload');

        $payload = json_decode($pendingJob->payload);
        $command = unserialize($payload->data->command);

        JobHistory::create([
            'uuid' => $payload->uuid,
            'payload' => 'Payload From request',
        ]);

        // for ($i = 0; $i < 5; $i++) {
        //     dispatch(new CreateProduct($requestData));
        //     $pendingJob = DB::table('jobs')
        //         ->where('queue', 'default')
        //         ->orderBy('id', 'desc')
        //         ->first('payload');

        //     $payload = json_decode($pendingJob->payload);
        //     $command = unserialize($payload->data->command);

        //     JobHistory::create([
        //         'uuid' => $payload->uuid,
        //         'payload' => 'Payload From request',
        //     ]);
        // }

        return response()->json(['success' => true, 'message' => 'Product created successfully.', 'data' => []], 201);
    }
}
