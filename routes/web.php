<?php

use Illuminate\Support\Facades\Route;

Route::get('/login-form', function () {
    return view('testLogin');
});


// Route::get('/testLogin', function () {
//     return view('testLogin');
// });
