<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'App\Http\Controllers\NewsController@show')->name('administrator.show-news');
Route::get('/student', 'App\Http\Controllers\NewsController@showstudent')->name('administrator.show-work');
Route::get('/read/{id}', 'App\Http\Controllers\NewsController@expand')->name('expand');
Route::get('/laravel', function () {
    return view('welcome');
});

Route::get('/lesson/{id}', 'App\Http\Controllers\LessonsController@lesson');

Route::get('/lessons/k', 'App\Http\Controllers\LessonsController@categories');
Route::get('/lessons/t', 'App\Http\Controllers\LessonsController@topics');
Route::get('/lessons/l', 'App\Http\Controllers\LessonsController@levels');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::multiauth('Administrator', 'administrator');
Route::post('/administrator/uploadFile', 'App\Http\Controllers\Administrator\DashboardController@uploadFile');
Route::post('/administrator/update/{id}', 'App\Http\Controllers\Administrator\DashboardController@update');
Route::delete('/administrator/delete/{id}', 'App\Http\Controllers\Administrator\DashboardController@delete');
Route::post('/administrator/updatePos', 'App\Http\Controllers\Administrator\DashboardController@updatePos');
Route::post('/administrator/updateVisibility/{id}', 'App\Http\Controllers\Administrator\DashboardController@updateVisibility');
Route::post('/administrator/uploadImage/{id}', 'App\Http\Controllers\Administrator\DashboardController@uploadImage');
Route::post('/administrator/changeImage/{id}', 'App\Http\Controllers\Administrator\DashboardController@changeImage');
Route::delete('/administrator/removeImage/{id}', 'App\Http\Controllers\Administrator\DashboardController@removeImage');

Route::post('/feedback', 'App\Http\Controllers\FeedbackController@postFeedback');

Route::group(['middleware'=>'administrators'], function() {
    Route::get('administrator/feedback', 'App\Http\Controllers\FeedbackController@listFeedback')->name('administrator.feedback');
    Route::get('/administrator/news', 'App\Http\Controllers\NewsController@news')->name('administrator.news');
    Route::get('/administrator/news/edit/{id}', 'App\Http\Controllers\NewsController@edit')->name('administrator.edit-news');
    Route::post('/administrator/news/update/{id}', 'App\Http\Controllers\NewsController@update')->name('administrator.update-news');
    Route::post('/administrator/news/uploadImage/{id}', 'App\Http\Controllers\NewsController@uploadImage');
    Route::post('/administrator/news/changeImage/{id}', 'App\Http\Controllers\NewsController@changeImage');
	Route::post('/administrator/news/removeImage/{id}', 'App\Http\Controllers\NewsController@removeImage');

	Route::delete('/administrator/news/delete/{id}', 'App\Http\Controllers\NewsController@delete');
	Route::post('administrator/post-news', 'App\Http\Controllers\NewsController@postNews')->name('administrator.post-news');
	Route::post('administrator/upload', 'App\Http\Controllers\NewsController@upload')->name('image.upload');
    
});
