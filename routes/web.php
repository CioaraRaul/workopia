<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/jobs', function(){
    return 'Available jobs';
})->name('jobs');

Route::match(['get','post'],'/submit', function(){
    return 'Submitted';
});

