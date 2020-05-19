<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('/', function () {
    return [
        'app' => 'Laravel 6 API  OK',
        'version' => '1.0.0',
    ];
});

Route::group(['namespace' => 'Auth'], function () {

    Route::post('login', ['as' => 'login', 'uses' => 'AuthController@login']);
    Route::get('new', ['as' => 'new', 'uses' => 'AuthController@new']);

    Route::post('register', ['as' => 'register', 'uses' => 'RegisterController@register']);
    // Send reset password mail
    Route::post('auth/recovery', 'ForgotPasswordController@sendPasswordResetLink');
    // handle reset password form process
    Route::post('auth/reset', 'ResetPasswordController@callResetPassword');

    Route::post('logout', ['as' => 'logout', 'uses' => 'LogoutController@logout']);

});

Route::group(['middleware' => ['jwt', 'jwt.auth']], function () {

        Route::group(['namespace' => 'Profile'], function () {

        Route::get('profile', ['as' => 'profile', 'uses' => 'ProfileController@me']);

        Route::put('profile', ['as' => 'profile', 'uses' => 'ProfileController@update']);

        Route::put('profile/password', ['as' => 'profile', 'uses' => 'ProfileController@updatePassword']);

    });

});

Route::group(['namespace' => 'Profile'], function () {

    Route::get('profile', ['as' => 'profile', 'uses' => 'ProfileController@me']);
    Route::get('indicadores', ['as' => 'profile', 'uses' => 'ProfileController@indicadores']);
    Route::get('expediente_c', ['as' => 'profile', 'uses' => 'ProfileController@expediente_c']);

    Route::put('profile/{id}', ['as' => 'profile', 'uses' => 'ProfileController@update']);

    Route::put('profile/password/{id}', ['as' => 'profile', 'uses' => 'ProfileController@updatePassword']);

});


Route::get('contabilidad', 'ExpedienteController@contabilidad');
Route::get('fiscal', 'ExpedienteController@Fiscal');
Route::get('laboral', 'ExpedienteController@Laboral');
Route::get('list', 'ExpedienteController@filesList');

Route::get('notificaciones', 'NotificacionesController@index');

Route::post('file', 'FilesController@saveFile');
Route::post('avatar', 'FilesController@saveAvatar');


Route::post('prospectos', 'ProspectosController@create');
Route::put('prospectos/{id}', 'ProspectosController@update');
Route::post('prospectos_u', 'ProspectosController@upload');
Route::delete('prospectos/{id}', 'ProspectosController@destroy');
Route::get('prospectos', 'ProspectosController@index');

Route::get('plantillas', 'FormatosController@index_p');
Route::delete('plantillas/{id}', 'FormatosController@destroy_p');
Route::get('formatos', 'FormatosController@index');
Route::post('formatos', 'FormatosController@create');
Route::put('formatos/{id}', 'FormatosController@update');
Route::delete('formatos/{id}', 'FormatosController@destroy');


Route::post('formatos_u', 'FormatosController@upload');
    




// Admin routes
Route::group(
    [], function () {
    // ['namespace' => 'Admin', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['role:admin']], function () {
        // Role permission routes
        Route::post('role-permission/assignAllPermission', ['as' => 'role-permission.assignAllPermission', 'uses' => 'ManageRolePermissionController@assignAllPermission']);
        Route::post('role-permission/removeAllPermission', ['as' => 'role-permission.removeAllPermission', 'uses' => 'ManageRolePermissionController@removeAllPermission']);
        Route::post('role-permission/assignRole', ['as' => 'role-permission.assignRole', 'uses' => 'ManageRolePermissionController@assignRole']);
        Route::post('role-permission/detachRole', ['as' => 'role-permission.detachRole', 'uses' => 'ManageRolePermissionController@detachRole']);
        Route::post('role-permission/storeRole', ['as' => 'role-permission.storeRole', 'uses' => 'ManageRolePermissionController@storeRole']);
        Route::post('role-permission/deleteRole', ['as' => 'role-permission.deleteRole', 'uses' => 'ManageRolePermissionController@deleteRole']);
        Route::get('role-permission/showMembers/{id}', ['as' => 'role-permission.showMembers', 'uses' => 'ManageRolePermissionController@showMembers']);
        Route::resource('role-permission', 'ManageRolePermissionController');
        Route::post('role-permission', 'ManageRolePermissionController@store');
        Route::get('permission', 'ManageRolePermissionController@view');


        //rutas Creadas para CRUD ROles
        Route::post('create-role', 'ManageRolePermissionController@storeCreate');
        Route::delete('role-permission/{id}', 'ManageRolePermissionController@destroy');
        Route::put('role-permission/{id}', 'ManageRolePermissionController@update');
       

    }
);
//controller permiso
//Route::resource('permission', 'ManageRolePermissionController');
