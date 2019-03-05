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

Route::group([], function () use ($router) {

    $router->get('login', ['uses'=>'Admin\AccessAdminController@getLogin', 'middleware'=>['have_login_admin']])->name('admin.login');
    $router->post('login', ['uses'=>'Admin\AccessAdminController@postLogin', 'middleware'=>['have_login_admin']])->name('admin.login.post');
    $router->get('logout', ['uses'=>'Admin\AccessAdminController@doLogout'])->name('admin.logout');

    $router->group(['middleware' => ['super_admin', 'preventBackHistory']], function () use ($router) {

        $router->group(['prefix' => 'profile'], function () use ($router) {
            $router->get('edit', ['uses'=>'Admin\AdminController@getProfile'])->name('admin.get_profile');
            $router->post('edit', ['uses'=>'Admin\AdminController@postProfile'])->name('admin.post_profile');
            $router->get('password', ['uses'=>'Admin\AdminController@getPassword'])->name('admin.get_password');
            $router->post('password', ['uses'=>'Admin\AdminController@postPassword'])->name('admin.post_password');
            $router->get('/', ['uses'=>'Admin\AdminController@profile'])->name('admin.profile');
        });

        $list_router = [
            
            'Admin\SettingController' => 'setting',
              'Admin\BukuController' => 'buku',
               'Admin\TransaksiController' => 'transaksi',
               'Admin\AnggotaController' => 'anggota',
            'Admin\AdminController' => 'admin',
//            'Admin\PurchaseController' => 'purchase',
            'Admin\ReportController' => 'report',
        ];

        foreach ($list_router as $controller => $link_name) {
            $router->get($link_name.'/data', $controller.'@dataTable')->name('admin.'.$link_name.'.dataTable');
            $router->resource($link_name, $controller.'', ['as'=>'admin']);
        }

        $router->group(['prefix' => 'customer/{customer_id}'], function () use ($router) {
            $router->get('data', 'Admin\PurchaseController@dataTable')->name('admin.purchase.dataTable');
            $router->resource('purchase', 'Admin\PurchaseController', ['as'=>'admin']);
        });

        $router->get('/', ['uses'=>'Admin\AdminController@dashboard'])->name('admin');

    });

});