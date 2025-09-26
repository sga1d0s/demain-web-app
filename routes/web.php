<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/health', function (Request $request) {
    try {
        DB::connection()->getPdo();
        return response()->json([
            'OK' => true, 
            'DB' => DB::connection()->getDatabaseName(),
            'user' => $request->user()?->name,
        ]);
    } catch (\Throwable $e) {
        return response()->json([
            'OK' => false, 
            'error' => $e->getMessage()], 500);
    }
})->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
