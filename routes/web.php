<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/jobs', function(){
    return 'Available jobs';
})->name('jobs');

Route::get('/test', function(){
    return response('HEllo world',200)-> header('Content-Type', 'text/html');
});

Route::get('notFound', function(){
    return response('not found', 400);
});


Route::get('/test2', function () {
return response() -> json(['name'=> 'Koln'])->cookie('name', 'John', 60);
});


Route::get('/download', function(){
    return response() -> download(public_path('favicon.ico'));
});


Route::get('/read-cookie', function(Request $request){
    $cookieValue = $request->cookie('name');
    return response()->json(['cookie' => $cookieValue]);
});
