<?php
//dd('api.php exécuté');

use App\Http\Controllers\Api\TaskController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::apiResource('tasks', TaskController::class);

Route::get('/test', function () {
    return response()->json(['message' => 'API OK']);
});

Route::get('/run-migrations', function () {
    // ATTENTION : à supprimer après usage !
    Artisan::call('migrate', ['--force' => true]);
    return 'Migrations exécutées avec succès !';
});
