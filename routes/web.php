<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get("/render", function () {
    return response()->json([
        "status" => "ok",
        "app" => config("app.name"),
    ]);
});
