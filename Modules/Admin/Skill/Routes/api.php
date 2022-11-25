<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'admin/skill'
],
    function () {
        Route::group([
            'middleware' => 'auth:admin'
        ], function () {
            Route::apiResource('lessons', LessonController::class);
            Route::apiResource('questions', QuestionController::class);
        });
    }
);
