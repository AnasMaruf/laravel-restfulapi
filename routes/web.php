<?php

use App\Jobs\GenerateUser;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/testing', function(){
    GenerateUser::dispatch();
});
