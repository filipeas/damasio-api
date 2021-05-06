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

Route::get('/', 'WEB\HomepageController@home')->name('site.home');
Route::get('/categoria/{category}/visualizar', 'WEB\HomepageController@showCategory')->name('site.category');
Route::get('/subcategoria/{subcategory}/visualizar/{page}', 'WEB\HomepageController@showSubcategory')->name('site.subcategory');
Route::get('/produto/{product}/visualizar', 'WEB\HomepageController@showProduct')->name('site.product');
