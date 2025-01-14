<?php
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::namespace('App\Http\Controllers')->group(function () {
    Route::get('/', 'LoginController@index')->name('/');
    Route::get('/index', 'LoginController@index')->name('index');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');
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
    Route::post('delUser', 'UserController@delUser')->name('delUser');
    Route::match(['get', 'post'], 'loadInfoUser', 'UserController@loadInfoUser')->name('loadInfoUser');
    Route::match(['get', 'post'], 'upInfoReg', 'UserController@upInfoReg')->name('upInfoReg');
    Route::match(['get', 'post'], 'upPasswordUser', 'UserController@upPasswordUser')->name('upPasswordUser');
    Route::match(['get', 'post'], 'loadPermitsUser', 'UserController@loadPermitsUser')->name('loadPermitsUser');
    Route::post('storeUser', 'UserController@storeUser')->name('storeUser');

    Route::post('expUsrFile', 'UserController@expUsrFile')->name('expUsrFile');

    //account
    Route::get('profile', 'AccountController@profile')->name('profile');
    Route::match(['get', 'post'], 'upPassword', 'AccountController@upPassword')->name('upPassword');
    Route::match(['get', 'post'], 'myPermits', 'AccountController@myPermits')->name('myPermits');
    Route::match(['get', 'post'], 'loadPermits', 'AccountController@loadPermits')->name('loadPermits');
    Route::match(['get', 'post'], 'asignPermit', 'AccountController@asignPermit')->name('asignPermit');


    Route::post('loadImageUser', 'AccountController@loadImageUser')->name('loadImageUser');
    Route::post('upImgUser', 'AccountController@upImgUser')->name('upImgUser');
    Route::post('upProfile', 'AccountController@upProfile')->name('upProfile');

    //users
    Route::get('listPosts', 'PostController@listPosts')->name('listPosts');
    Route::post('loadPosts', 'PostController@loadPosts')->name('loadPosts');
    Route::post('getLastPosts', 'PostController@getLastPosts')->name('getLastPosts');
    Route::get('editPost/{reg}', 'PostController@editPost')->name('editPost');
    Route::get('addPost', 'PostController@addPost')->name('addPost');
    Route::post('delPost', 'PostController@delPost')->name('delPost');
    Route::match(['get', 'post'], 'upload', 'PostController@uploadImageCkeditor')->name('uploadImageCkeditor');
    Route::match(['get', 'post'], 'imageckeditor/{segment}', 'PostController@imageckeditor')->name('imageckeditor');
    Route::post('storePost', 'PostController@storePost')->name('storePost');
    Route::post('loadImagePost', 'PostController@loadImagePost')->name('loadImagePost');
    Route::post('upImgPost', 'PostController@upImgPost')->name('upImgPost');
    Route::post('upPost', 'PostController@upPost')->name('upPost');

    Route::match(['get', 'post'], 'loadGraphLogs', 'LogController@loadGraphLogs')->name('loadGraphLogs');
    Route::get('logs', 'LogController@listLogs')->name('logs');
    Route::match(['get', 'post'], 'loadLogs', 'LogController@loadLogs')->name('loadLogs');
    Route::post('delLog', 'LogController@delLog')->name('delLog');
    Route::match(['get', 'post'], 'searchGlobal', 'SearchController@searchGlobal')->name('searchGlobal');

     //reservas
     Route::get('listRevs', 'ReservaController@listRevs')->name('listRevs');
     Route::get('editReserva/{id}', 'ReservaController@editReserva')->name('editReserva');
     Route::get('crearReserva', 'ReservaController@crearReserva')->name('crearReserva');
     Route::post('storeReserva', 'ReservaController@storeReserva')->name('storeReserva');
     Route::post('updateReserva', 'ReservaController@updateReserva')->name('updateReserva');
     Route::post('delReserva', 'ReservaController@delReserva')->name('delReserva');
     Route::post('loadReservas', 'ReservaController@loadReservas')->name('loadReservas');
});