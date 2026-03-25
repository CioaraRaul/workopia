<?php

use Illuminate\Http\Request;
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

Route::get('/test', function(Request $request){
    return [
    'method' => $request -> method(),
    'ip' => $request -> ip(),
    'header' => $request -> header('Accept')
    ];
});

Route::get('/users', function(Request $request){
    return $request -> query('name');
});
