<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'prefix' => 'common'
    ],
    function () {
        Route::post('upload','MediaController@upload');
        Route::post('upload/other','MediaController@uploadOtherFiles');
    }
);
