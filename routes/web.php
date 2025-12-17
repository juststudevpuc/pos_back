<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');

});
// Route::get('/test-db', function () {
//     try {
//         // Get database name
//         $dbName = DB::connection('mongodb')->getMongoDB()->getDatabaseName();

//         // Count documents in users collection
//         $count = DB::connection('mongodb')
//             ->getCollection('users')
//             ->count();

//         return response()->json([
//             'status' => 'Connected to Atlas',
//             'database' => $dbName,
//             'users_count' => $count
//         ]);
//     } catch (\Exception $e) {
//         return response()->json([
//             'status' => 'Connection failed',
//             'error' => $e->getMessage()
//         ]);
//     }
// });
// Route::get('/delete-users', function () {
//     try {
//         $deleted = DB::connection('mongodb')
//             ->table('users')
//             ->delete();

//         return response()->json([
//             'status' => 'Success',
//             'deleted_count' => $deleted
//         ]);
//     } catch (\Exception $e) {
//         return response()->json([
//             'status' => 'Error',
//             'error' => $e->getMessage()
//         ]);
//     }
// });

// In routes/web.php or api.php

// use Illuminate\Support\Facades\Route;
// Route::get('/test-mongo', function () {
//     dd(config('database.connections.mongodb'));
// });

