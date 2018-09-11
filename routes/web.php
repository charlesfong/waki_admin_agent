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

Auth::routes();

// url -> waki-data.com/
// if admin, go to /dashboard
// if not admin, go to /data
// if not authenticated go to /login
Route::get('/', function () {
    if(Auth::check())
    {
    	if(Auth::user()->roles->first()->slug == 'admin')
    	{
    		return redirect('/dashboard'); // return redirect()->route('dashboard');
    	}
    	else
    	{
    		return redirect('/data');
    	}
    }
    else
    {
    	return redirect('/login');
    }
});

Route::get('/dashboard', 'DashboardController@index')
	->name('dashboard')
	->middleware('can:dashboard');

Route::get('/data', 'DataController@index')
	->name('data')
	->middleware('auth');

//-- PASSWORD --//
Route::post('/changePassword','AjaxController@changePassword')->name('changePassword');

//-- AJAX --//
Route::post('/selectCountry', 'AjaxController@selectCountry')
    ->name('select-country');

Route::post('/checkBranchCode', 'AjaxController@checkBranchCode')
    ->name('check-branch-code');

Route::post('/checkChangePassword', 'AjaxController@checkChangePassword')
    ->name('check-change-password');

// Route::get('/home', 'HomeController@index')->name('home');

// Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

// Route::get('/', 'MemberController@index')->middleware('auth');

// Route::get('/', function () {
//     return view('welcome');
// });