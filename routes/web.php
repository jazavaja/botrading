<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/start','StrategyController@doingAnalytics');

Route::get('/work',function ()
{
    Storage::disk('log')->delete('laravel.log');
    Artisan::call('queue:work');
});

Route::get('/logout',function (){
    Auth::logout();
    return redirect('login');
});

Route::get('/dashboard', 'HomeController@index');

Route::get('/',function (){
    return redirect('/login');
});


Route::post('/indicatorNewSave','admin\Indicator@addNewIndicator');
Route::get('/deleteIndicator/{id}','admin\Indicator@removeIndicator');

Route::post('/login','Login@loginPost');

Route::get('/login','Login@viewLogin');

Route::get('/we',function (){
    $user = new App\User();
    $user->password = Hash::make('javad123');
    $user->email = 'javadesmesh@gmail.com';
    $user->name = 'Javad';
    $user->save();
});

