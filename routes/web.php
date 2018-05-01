<?php

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

Route::get('/battlenet-home', function () {
    $characters = DB::table('characters')
        ->orderBy('updated_at', 'desc')
        ->get()
        ->toJson();
    return view('pages.home')->with('characters', $characters);
});

Route::post('/battlenet-submit', [
    'uses' => 'BattlenetController@submit',
    'as' => 'submit-url'
]);

Route::post('/battlenet-ranking-submit', [
    'uses' => 'BattlenetController@bracket',
    'as' => 'submit-bracket'
]);

Route::get('/battlenet-ranking', [
    'uses' => 'BattlenetController@ranking',
]);