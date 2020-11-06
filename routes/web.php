<?php

/*
 * This file is part of the Jiannei/lumen-api-starter.
 *
 * (c) Jiannei <longjian.huang@foxmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

Route::get('/', function () {
    return app()->version();
});

$router->group(['prefix' => 'api/v1'], function () use ($router) {
    Route::get('author', function () {
        $response = Http::withOptions(['timeout' => 3])->get('https://api.github.com/users/Jiannei');
        $response->throw();

        return $response->json();
    });

    Route::get('configurations', 'ExampleController@configurations');
    Route::get('logs', 'ExampleController@logs');
    Route::get('enums', 'ExampleController@enums');
    Route::post('enums', 'ExampleController@enums');

    Route::post('users', 'UsersController@store');
    Route::get('users/{id}', 'UsersController@show');
    Route::get('users', 'UsersController@index');
    Route::put('users', 'UsersController@update');
    Route::put('usersPassword', 'UsersController@updatePassword');
    Route::put('userSetting', 'UserSettingController@update');

    Route::post('authorization', 'AuthorizationController@store');
    Route::delete('authorization', 'AuthorizationController@destroy');
    Route::put('authorization', 'AuthorizationController@update');
    Route::get('authorization', 'AuthorizationController@show');

    Route::get('log_list', 'LogsController@list');

    Route::post('upload', 'UploadController@upload');

    Route::post('role', 'RoleController@store');
    Route::get('roles', 'RoleController@index');
    Route::put('role', 'RoleController@update');

    Route::get('permissionMenus', 'PermissionController@permissionMenus');
    Route::get('menus', 'PermissionController@menus');
    Route::post('permissionMenu', 'PermissionController@store');
    Route::put('permissionMenu', 'PermissionController@update');

    Route::get('resource/images', 'ResourceController@getImages');
    Route::post('resource/image', 'ResourceController@uploadImage');
    Route::delete('resource/image', 'ResourceController@deleteImage');

    Route::get('loginLogs', 'LoginLogController@index');

    Route::get('settings', 'SettingController@index');
    Route::post('setting', 'SettingController@store');
    Route::put('settingAll', 'SettingController@updateAll');
    Route::put('setting', 'SettingController@update');
});