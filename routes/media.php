<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MediaUploadController;

Route::post('/admin/media/upload',
    [MediaUploadController::class,'upload']
);