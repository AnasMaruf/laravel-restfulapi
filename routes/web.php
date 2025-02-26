<?php

use App\Jobs\GenerateUser;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/testing', function(){
    Cache::remember('users', 100, function () {
        return User::all();
    });
    dump(cache('users'));

});
