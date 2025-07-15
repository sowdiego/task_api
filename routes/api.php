<?php
//dd('api.php exécuté');

use App\Http\Controllers\Api\TaskController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::apiResource('tasks', TaskController::class);

Route::get('/tasks-paginated', [TaskController::class, 'paginated']);

Route::get('/test', function () {
    return response()->json(['message' => 'API OK']);
});

Route::get('/run-migrations', function () {
    try {
        Artisan::call('migrate', ['--force' => true]);
        return response()->json([
            'success' => true,
            'output' => Artisan::output()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ], 500);
    }
});


Route::get('/run-swagger-generate', function () {
    Artisan::call('l5-swagger:generate');
    return response()->json(['message' => 'Swagger doc générée']);
});

