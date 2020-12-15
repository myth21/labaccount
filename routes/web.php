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

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use App\Helpers\AppHelper;

if (config('app.debug')) {
    Artisan::call('view:clear');
    Artisan::call('cache:clear'); // Clear cash
    flush();
}

Route::get('/', function () { // Closure is not cached
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function() {

    Route::group(['prefix' => 'labs'], function () {
        AppHelper::setRouteNames('lab');
        Route::get('ajax/_item', 'LabController@_item')->name('lab._item');
    });
    Route::group(['prefix' => 'labfiles'], function () {
        Route::get('download/{id}', 'LabfileController@download')->name('labfile.download')->middleware('CheckAuthorization:teacher,student');
        Route::delete('destroy', 'LabfileController@destroy')->name('labfile.destroy')->middleware('CheckAuthorization:teacher');
    });

    Route::group(['prefix' => 'lab-student-exes'], function () {
        AppHelper::setRouteNames('labstudentexe');
        Route::get('show/{id}', 'LabstudentexeController@show')->name('labstudentexe.show');
        Route::get('add/{id}', 'LabstudentexeController@add')->name('labstudentexe.add');
        Route::post('save', 'LabstudentexeController@save')->name('labstudentexe.save');
    });
    Route::group(['prefix' => 'labstudentexefiles'], function () {
        Route::get('download/{id}', 'LabstudentexefileController@download')->name('labstudentexefile.download')->middleware('CheckAuthorization:teacher,student');
        Route::delete('destroy', 'LabstudentexefileController@destroy')->name('labstudentexefile.destroy')->middleware('CheckAuthorization:teacher');
    });

    Route::group(['prefix' => 'users'], function () {
        Route::get('/{role?}', 'UserController@index')->where('role', '(admin|teacher|student)')->name('user.index');
        AppHelper::setRouteNames('user');
    });

    Route::group(['prefix' => 'groups'], function () {
        AppHelper::setRouteNames('group');
    });

    Route::group(['prefix' => 'courses'], function () {
        AppHelper::setRouteNames('course');
    });

    Route::group(['prefix' => 'students'], function () {
        AppHelper::setRouteNames('student');
    });

});