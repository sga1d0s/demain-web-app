<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/health', function(){
    try{
        DB::connection()->getPdo();
        return response()->json(['ok' => true, 'db' => DB::connection()->getDatabaseName()]);
    } catch (\Throwable $e) {
        return response()->json(['ok' => false, 'error' => $e->getMessage()], 500);
    }
});