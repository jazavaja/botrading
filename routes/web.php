<?php

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

Route::get('/rara',function ()
{
    \App\Http\Controllers\Telegram::sendTelegram('test');
});
