<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/start','StrategyController@doingAnalytics');
Route::get('/work',function ()
{
    Storage::disk('log')->delete('laravel.log');
    Artisan::call('queue:work');
});
Route::get("/",function (){
    return view('dashboard');
});
Route::get("/test","Test@testaddJob");

