<?php

use Illuminate\Support\Facades\Route;

Route::post('/login', 'API\AuthController@login');
Route::post('logout', 'API\AuthController@logout');

Route::group(['prefix' => 'user', 'middleware' => ['auth:api']], function () {
    // CRUD DAS CATEGORIAS
    Route::resource('/category', 'API\CategoryController');
    Route::post('/category/{category}/pdf', 'API\CategoryController@storePDF');
    // CRUD DAS SUBCATEGORIAS
    Route::resource('/subcategory', 'API\SubcategoryController');
    // CRUD DAS MARCAS
    Route::resource('/brand', 'API\BrandController');
    Route::post('/brand/{brand}/image', 'API\BrandController@storeImage');
    // CRUD DOS GRUPOS
    Route::resource('/group', 'API\GroupController');
    // CRUD DOS PRODUTOS
    Route::resource('/product', 'API\ProductController');
    Route::get('/product/bycategory/{category}', 'API\ProductController@listByCategory');
    Route::get('/product/bysubcategory/{subcategory}', 'API\ProductController@listBySubcategory');
    Route::post('/product/{product}/image', 'API\ProductController@storeImage');
    Route::post('/product/{product}/brands', 'API\ProductController@UpdateBrands');
    // CRUD DE MANIPULAÇÃO DAS IMPORTAÇÕES DAS PLANILHAS XML DE OUTRO SISTEMA
    Route::post('/import/xml', 'API\SpreadsheetImport@XMLFileImport');
});
