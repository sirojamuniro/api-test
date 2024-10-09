<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;

Route::group(
    ['middleware' => ['api', 'throttle']],
    function ($router) {
        Route::apiResource('authors', AuthorController::class);
        Route::get('authors/{id}/books', [AuthorController::class, 'books']);
        Route::apiResource('books', BookController::class);
    }
);
