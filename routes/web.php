<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Auth::routes();

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');
Route::post('/register/{register}', 'Auth\RegisterController@remoteCheck');
Route::get('/register/confirm', 'Auth\RegisterController@confirm');
Route::post('/profile/{profile}', 'ProfileController@remoteCheck');
Route::post('password/reset/{reset}', 'Auth\ForgotPasswordController@remoteCheck');
Route::get('/editor', 'HomeController@editor');
Route::get('/getTemplateContent/{id}', 'HomeController@getTemplateContent');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/editor/{productId}', 'HomeController@editor');
    Route::resource('project', 'ProjectController');
    Route::resource('profile', 'ProfileController');
    Route::resource('projects', 'ProjectController');
    Route::post('projects/remoteCheck', 'ProjectController@remoteCheck');
    Route::get('schedules/getJSON', 'ScheduleController@getJSON');
    Route::resource('schedules', 'ScheduleController');
});

Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::get('/', 'Auth\LoginController@index');
    Route::resource('login', 'Auth\LoginController');
    Route::group(['middleware' => ['admin']], function (){
        Route::get('/import', 'HomeController@importContents');
        Route::get('/', 'UserController@index');
        Route::post('logout', 'Auth\LoginController@logout');
        Route::resource('customers', 'UserController');
        Route::get('profile', 'AdminController@profile');
        Route::post('changePassword', 'AdminController@changePassword');
        Route::get('home', 'UserController@index');
        Route::resource('users', 'UserController');
        Route::resource('admins', 'AdminController');
        
        Route::get('templates/{param}/editor', 'TemplateController@create');
        Route::delete('templates', 'TemplateController@deleteMultipleTemplates');
        Route::post('templates/remoteCheck', 'TemplateController@remoteCheck');
        Route::get('templates/products/data', ['as'=>'templates.products.getdata','uses'=>'TemplateController@productsData']);
        Route::resource('templates', 'TemplateController');

        Route::post('/shapes/{shape}', 'ShapeController@remoteCheck');
        Route::delete('shapes', 'ShapeController@deleteMultipleShapes');
        Route::post('shapes/getShapes/{id}', 'ShapeController@getShapes');
        Route::get('shapes/getCategories/{param}', 'ShapeController@getCategories');
        Route::resource('shapes', 'ShapeController');

        Route::get('cliparts/getClipartsByCategory/{categoryId}', 'ClipartController@getClipartsByCategory');
        Route::get('cliparts/getClipartRootCategories', 'ClipartController@getClipartRootCategories');
        Route::post('/cliparts/{clipart}', 'ClipartController@remoteCheck');
        Route::delete('cliparts', 'ClipartController@deleteMultipleCliparts');
        Route::resource('cliparts', 'ClipartController');
    	Route::put('products/updateKit/{id}', 'ProductController@updateKit');
    	Route::get('products/getKitProduct/{id}', 'ProductController@getKitProduct');
    });

    Route::get('forgotPassword', 'AdminController@showForgotPassword');
    Route::get('resetPassword', 'AdminController@showResetPassword');
    Route::post('askResetPassword', 'AdminController@askResetPassword');
    Route::post('resetPassword', 'AdminController@performResetPassword');

});