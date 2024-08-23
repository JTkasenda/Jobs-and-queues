<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/upload', function(){
    return view('upload-file');
});
Route::post('/upload', function (){
    if(request()->has('mycsv')){
    $data = array_map('str_getcsv', file(request()->mycsv));
    $headers = $data[0];
    unset($data[0]);
    return $headers;

    }
    else{
        return "Please upload file";
    }
});
