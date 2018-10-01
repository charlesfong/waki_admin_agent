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
    		return redirect()->route('dashboard');
    	}
    	else
    	{
    		return redirect()->route('data');
    	}
    }
    else
    {
    	return redirect()->route('login');
    }
});

//-- DASHBOARD --//
Route::get('/dashboard', 'DashboardController@index')
	->name('dashboard')
	->middleware('can:dashboard');

//-- MASTER DATA --//
Route::get('/data', 'DataController@index')
	->name('data')
	->middleware('auth');

//-- MASTER BRANCH --//
Route::group(['prefix' => 'branch'], function () {
	//Browse
	Route::get('/', 'BranchController@index')
		->name('branch')
		->middleware('can:browse-branch,add-branch');
	//Add
	Route::post('/', 'BranchController@store')
		->name('store_branch')
		->middleware('can:add-branch');
	//Edit
	Route::post('/edit/', 'BranchController@update')
        ->name('update_branch')
        ->middleware('can:edit-branch');
    //Delete
	Route::post('/{branch}', 'BranchController@delete')
		->name('delete_branch')
		->middleware('can:delete-branch,branch');
});

//-- MASTER USER --//
Route::group(['prefix' => 'user'], function () {
	//Browse
	Route::get('/', 'UserController@index')
		->name('user')
		->middleware('can:browse-user,add-user');
	//Add
	Route::post('/', 'UserController@store')
		->name('store_user')
		->middleware('can:add-user');
	//Edit
	Route::post('/edit/', 'UserController@update')
        ->name('update_user')
        ->middleware('can:edit-user');
    //Delete
	Route::post('/{user}', 'UserController@delete')
		->name('delete_user')
		->middleware('can:delete-user,user');
});

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

// Route::get('/', 'MemberController@index')->middleware('auth');

// Route::get('/', function () {
//     return view('welcome');
// });