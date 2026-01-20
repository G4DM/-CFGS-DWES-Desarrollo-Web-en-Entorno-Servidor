<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/greeting', function () {
    return 'Hello World';
});

Route::get('/user/{id}', function (string $id) {
    return 'User ' . $id;
});

Route::get('/table/{number}', function ($number) {
    for ($i = 1; $i <= 10; $i++) {
        echo "$i * $number = " . $i * $number . "<br>";
    };
});

Route::get('/user/{name?}', function (?string $name = null) {
    return $name;
});

Route::get('/user/{name?}', function (?string $name = "John") {
    return $name;
});

Route::get('/', function () {
    return view('home', array('nombre' => 'Gabi'));
});

Route::get('/greeting', function () {
    return view('greeting', ['name' => 'Gabi']);
});

Route::get('/child', function() {
    return view('child');
});