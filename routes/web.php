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

// Route::get('catalogo', 'WEB\HomepageController@showCatalog'); // rota de teste. apagar depois...

Route::get('/', 'WEB\HomepageController@home')->name('site.home');
Route::get('/categoria/{category}/visualizar', 'WEB\HomepageController@showCategory')->name('site.category');
Route::get('/subcategoria/{subcategory}/visualizar', 'WEB\HomepageController@showSubcategory')->name('site.subcategory');
Route::get('/produto/{product}/visualizar', 'WEB\HomepageController@showProduct')->name('site.product');

// ROTA DE LOGIN
Route::get('/login', 'WEB\LoginController@formLogin')->name('login')->middleware('guest_session');
Route::post('login/do', 'WEB\LoginController@login')->name('login.do');
Route::get('logout', 'WEB\LoginController@logout')->name('logout');

// ROTAS DO USUÁRIO
Route::group(['prefix' => 'usuario', 'middleware' => ['check_session', 'check_user']], function () {
    // ROTA DA TELA INICIAL
    Route::get('home', 'WEB\UserController@home')->name('user.home');

    // ROTA DE CONFIGURAÇÕES
    Route::get('configuracoes', 'WEB\UserController@config')->name('user.config');
    Route::post('configurar/do', 'WEB\UserController@executeConfig')->name('user.config.do');

    // ROTA DA TELA DE MANIPULAÇÃO DOS DADOS DA CATEGORIAS
    Route::get('categoria', 'WEB\CategoryController@index')->name('user.category.index');
    Route::get('categoria/{category}/visualizar', 'WEB\CategoryController@show')->name('user.category.show');
    Route::get('categoria/cadastrar', 'WEB\CategoryController@create')->name('user.category.create');
    Route::post('categoria/cadastrar/do', 'WEB\CategoryController@store')->name('user.category.store');
    Route::get('categoria/{category}/editar', 'WEB\CategoryController@edit')->name('user.category.edit');
    Route::patch('categoria/{category}/editar/do', 'WEB\CategoryController@update')->name('user.category.update');
    Route::delete('categoria/excluir/{category}/do', 'WEB\CategoryController@destroy')->name('user.category.destroy');

    // ROTA DA TELA DE MANIPULAÇÃO DOS DADOS DA SUBCATEGORIAS
    Route::get('categoria/{category}', 'WEB\SubcategoryController@index')->name('user.subcategory.index');
    Route::get('subcategoria/{subcategory}/visualizar', 'WEB\SubcategoryController@show')->name('user.subcategory.show');
    Route::get('subcategoria/{category}/cadastrar', 'WEB\SubcategoryController@create')->name('user.subcategory.create');
    Route::post('subcategoria/{category}/cadastrar/do', 'WEB\SubcategoryController@store')->name('user.subcategory.store');
    Route::get('subcategoria/{subcategory}/editar', 'WEB\SubcategoryController@edit')->name('user.subcategory.edit');
    Route::put('subcategoria/{subcategory}/{category}/editar/do', 'WEB\SubcategoryController@update')->name('user.subcategory.update');
    Route::delete('subcategoria/excluir/{subcategory}/{category}/do', 'WEB\SubcategoryController@destroy')->name('user.subcategory.destroy');

    // ROTA DA TELA DE MANIPULAÇÃO DAS MARCAS
    Route::get('marca', 'WEB\BrandController@index')->name('user.brand.index');
    Route::get('marca/cadastrar', 'WEB\BrandController@create')->name('user.brand.create');
    Route::post('marca/cadastrar/do', 'WEB\BrandController@store')->name('user.brand.store');
    Route::get('marca/{brand}/editar', 'WEB\BrandController@edit')->name('user.brand.edit');
    Route::put('marca/{brand}/editar/do', 'WEB\BrandController@update')->name('user.brand.update');
    Route::delete('marca/excluir/{brand}/do', 'WEB\BrandController@destroy')->name('user.brand.destroy');

    // ROTA DA TELA DE MANIPULAÇÃO DOS PRODUTOS
    Route::get('produto/{product}/categoria/{category}/visualizar', 'WEB\ProductController@show')->name('user.product.show');
    Route::get('produto/{subcategory}/{category}/cadastrar', 'WEB\ProductController@create')->name('user.product.create');
    Route::post('produto/{subcategory}/cadastrar/do', 'WEB\ProductController@store')->name('user.product.store');
    Route::get('produto/{product}/categoria/{category}/subcategoria/{subcategory}/editar', 'WEB\ProductController@edit')->name('user.product.edit');
    Route::post('produto/{product}/{subcategory}/editar/do', 'WEB\ProductController@update')->name('user.product.update');
    Route::delete('produto/{product}/{subcategory}/excluir/do', 'WEB\ProductController@destroy')->name('user.product.destroy');

    // ROTA DA TELA DE IMPORTAÇÃO DE PLANILHA XML
    Route::get('importar/xml', 'WEB\SpreadsheetImportController@index')->name('user.import.xml');
    Route::post('importar/xml/do', 'WEB\SpreadsheetImportController@store')->name('user.import.xml.do');

    // ROTA DA TELA DE GERAÇÃO DOS PDF's
    Route::get('gerar/pdf', 'WEB\SpreadsheetImportController@indexGeneratePDF')->name('user.generate.pdf');
    Route::get('acompanhar/progresso/pdf', 'WEB\SpreadsheetImportController@progressGenerate')->name('user.progress.generate.pdf');
    Route::get('gerar/pdf/do', 'WEB\SpreadsheetImportController@storeGeneratePDF')->name('user.generate.pdf.do');
});
