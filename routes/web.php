<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/status', function () {
    $updatedAt = now()->toISOString();
    $mysqlVersion = DB::scalar("SELECT version();");
    $mysqlMaxConnectionsResult = DB::select("SHOW VARIABLES LIKE 'max_connections';");
    $mysqlMaxConnections = intval($mysqlMaxConnectionsResult[0]->Value);
    $mysqlThreadsConnectedResult = DB::select("SHOW STATUS LIKE 'Threads_connected';");
    $mysqlThreadsConnected = intval($mysqlThreadsConnectedResult[0]->Value);

    $data = [
        "updated_at" => $updatedAt,
        "mysql" => [
            "version" => $mysqlVersion,
            "max_connections" => $mysqlMaxConnections,
            "threads_connected" => $mysqlThreadsConnected
        ]
    ];

    return response()->json($data);
});
