<?php

use Illuminate\Support\Facades\Route;

Route::middleware('api')->group(function () {

    Route::get('/services', function () {
        return response()->json([
            'message' => 'Service API ready'
        ]);
    });

});
