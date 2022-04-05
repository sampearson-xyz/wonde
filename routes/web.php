<?php

use App\Http\Controllers\LessonController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/lessons');
});

Route::resource('/lessons', LessonController::class);

