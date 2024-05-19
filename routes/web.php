<?php
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::namespace('App\Http\Controllers')->group(function () {
    Route::get('/', 'LoginController@index')->name('/');
    Route::get('/index', 'LoginController@index')->name('index');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');
    /*Route::post('ajxlogin', 'LoginController@ajxlogin')->name('ajxlogin');
    Route::post('verifyEmail', 'LoginController@verifyEmail')->name('verifyEmail');
    Route::match(['get', 'post'], 'reset', 'LoginController@reset')->name('reset');
    Route::post('uppassword', 'LoginController@uppassword')->name('uppassword');
    Route::get('singup', 'SingUpController@index')->name('singup');
    Route::post('ajxregister', 'SingUpController@store')->name('ajxregister');*/
});

Route::namespace('App\Http\Controllers')->middleware(['auth'])->group(function () {
    
    //modules
    Route::get('listModules', 'ModuleController@listModules')->name('listModules');
    Route::post('loadModules', 'ModuleController@loadModules')->name('loadModules');
    Route::get('editModule/{reg}', 'ModuleController@editModule')->name('editModule');
    Route::get('addModule', 'ModuleController@addModule')->name('addModule');
    Route::post('delModule', 'ModuleController@delModule')->name('delModule');
    Route::post('storeModule', 'ModuleController@storeModule')->name('storeModule');
    Route::post('loadSubModules', 'ModuleController@loadSubModules')->name('loadSubModules');
    Route::post('loadInfoModule', 'ModuleController@loadInfoModule')->name('loadInfoModule');
    Route::post('upInfoModule', 'ModuleController@upInfoModule')->name('upInfoModule');
    Route::post('loadInfoSubModule', 'ModuleController@loadInfoSubModule')->name('loadInfoSubModule');

    //users
    Route::get('listUsers', 'UserController@listUsers')->name('listUsers');
    Route::post('loadUsers', 'UserController@loadUsers')->name('loadUsers');
    Route::get('editUser/{reg}', 'UserController@editUser')->name('editUser');
    Route::get('addUser', 'UserController@addUser')->name('addUser');

    //account
    Route::get('profile', 'AccountController@profile')->name('profile');
    Route::get('logs', 'AccountController@logs')->name('logs');
    Route::match(['get', 'post'], 'upPassword', 'AccountController@upPassword')->name('upPassword');
    Route::match(['get', 'post'], 'myPermits', 'AccountController@myPermits')->name('myPermits');
    Route::match(['get', 'post'], 'loadPermits', 'AccountController@loadPermits')->name('loadPermits');
    Route::match(['get', 'post'], 'asignPermit', 'AccountController@asignPermit')->name('asignPermit');


    Route::post('loadImageUser', 'AccountController@loadImageUser')->name('loadImageUser');
    Route::post('upImgUser', 'AccountController@upImgUser')->name('upImgUser');
    Route::post('upProfile', 'AccountController@upProfile')->name('upProfile');
});