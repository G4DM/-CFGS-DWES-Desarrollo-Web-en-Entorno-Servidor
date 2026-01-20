<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Definición de rutas del ejercicio (solo devuelven un string)

// Route::get('/', function () {
//     return 'Main page';
// });

Route::get('/', function () {
    return view('home');
});

// Route::get('/login', function() {
//     return 'Login Page';
// });

Route::get('/login', function () {
    return view('auth.login');
});

// Route::get('/logout', function() {
//     return 'Logout Page';
// });

// Route::get('/catalog', function() {
//     return 'Catalog Page';
// });

Route::get('/catalog', function () {
    return view('catalog.index');
});

// Route::get('/catalog/show/{id}', function($id) {
//     return 'Catalog Show Page with id '. $id;
// });

Route::get('/catalog/show/{id}', function ($id) {
    return view('catalog.show', array('id'=>$id));
});

// Route::get('/catalog/create', function() {
//     return 'Catalog Create Page';
// });

Route::get('/catalog/create', function () {
    return view('catalog.create');
});

// Route::get('/catalog/edit/{id}', function($id) {
//     return 'Catalog Edit Page with id '. $id;
// });

Route::get('/catalog/edit/{id}', function ($id) {
    return view('catalog.edit', array('id'=>$id));
});