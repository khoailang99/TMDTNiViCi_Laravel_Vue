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

Route::get('/', 'HomeController@index')->name('home');

// Lấy các sản phẩm theo phân trang
Route::get('/products', 'HomeController@getAllProdByPagination');

// Lấy bộ lọc theo loại sản phẩm
Route::get('/prod-catalog-filters', 'HomeController@getFilters_Category_ProdType');

// Lấy sản phẩm theo bộ lọc
Route::get('/prod-filters', 'HomeController@getProductsFilter');

// Lấy sản phẩm theo danh mục hoặc loại sản phẩm
Route::get('/prod-catalog', 'HomeController@getProds_Category_ProdType');

// Tìm kiếm sản phẩm
Route::get('/search-product', 'HomeController@SearchProducts_HC');

// Xem chi tiết sản phẩm
Route::get('/prod-detail/{prodID}', 'HomeController@ProductDetails')->name('product');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
