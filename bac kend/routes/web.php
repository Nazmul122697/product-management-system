<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;


Route::view('/{any}', 'welcome')->where('any', '.*');
