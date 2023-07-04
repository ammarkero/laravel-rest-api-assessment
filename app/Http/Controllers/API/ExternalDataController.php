<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExternalData;

class ExternalDataController extends Controller
{
    public function retrieve()
    {
        $url = 'https://jsonplaceholder.typicode.com/users/1/todos';
        $response = @file_get_contents($url);

        if ($response === false) {
            return response()->json([
                'message' => 'Failed to retrieve external data'
            ], 500);
        }

        $data = json_decode($response, true);

        return response()->json([
            'message' => 'External data retrieved successfully',
            'data' => $data
        ], 200);
    }

    public function store()
    {
        $count = 0;

        $url = 'https://jsonplaceholder.typicode.com/users/1/todos';
        $response = @file_get_contents($url);

        if ($response === false) {
            return response()->json([
                'message' => 'Failed to retrieve external data'
            ], 500);
        }

        $data = json_decode($response, true);

        foreach ($data as $item) {
            $externalData = ExternalData::create([
                'user_id' => 1,
                'data' => $item
            ]);

            if ($externalData) {
                $count++;
            }
        }

        return response()->json([
            'message' => 'External data stored successfully',
            'count' => $count
        ], 200);
    }

}
