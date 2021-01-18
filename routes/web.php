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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', function() {
    return view('home');
})->name('home')->middleware('auth');
Route::group([
    'middleware' => 'auth'
        ], function() {
    Route::get('/import', 'ImportController@index');
    Route::post('/import_csv', 'ImportController@store')->name('import_csv');
    Route::get('import-list', 'ImportController@listImport');
    Route::get('all-import-list', 'ImportController@importList');
    Route::post('delete_import_ID', 'ImportController@deleteImport');
});

Route::get('/mailing','MailingController@index');
Route::get('/mailing/{id}','MailingController@index');
Route::post('/mail_submit','MailingController@store')->name('mail_submit');
Route::get('/send-mail','MailSendController@mailsend');
Route::post('get-email-by-name','MailingController@getemailbyname');
Route::post('uploadImage','MailingController@uploadimage');
