<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return "Hola desde home";
});

Route::get("/render", function () {
    return "Hola desde render";
});
