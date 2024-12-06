<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatusController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $updatedAt = now()->toISOString();
        $mysqlVersion = DB::scalar('SELECT version();');
        $mysqlMaxConnectionsResult = DB::select('SHOW VARIABLES LIKE \'max_connections\';');
        $mysqlMaxConnections = intval($mysqlMaxConnectionsResult[0]->Value);
        $mysqlThreadsConnectedResult = DB::select('SHOW STATUS LIKE \'Threads_connected\';');
        $mysqlThreadsConnected = intval($mysqlThreadsConnectedResult[0]->Value);

        $data = [
            'updated_at' => $updatedAt,
            'mysql' => [
                'version' => $mysqlVersion,
                'max_connections' => $mysqlMaxConnections,
                'threads_connected' => $mysqlThreadsConnected
            ]
        ];

        return response()->json($data);
    }
}
