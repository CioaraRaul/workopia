<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/jobs', function(){
    return 'Available jobs';
})->name('jobs');

Route::get('/posts/{id}', function(string $id){
    return 'POST ' . $id;
});

Route::get('/users/{id}', function(string $id){
    return 'User ' . $id;
});
