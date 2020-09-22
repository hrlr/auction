<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
 */

use Illuminate\Http\Request;

Route::get('/', 'AuctionController@index');

/*
 * Auction
 */

Route::get('auction', 'AuctionController@index')->name('auction.index');
Route::get('auction/create', 'AuctionController@create')->name('auction.create');
Route::post('auction', 'AuctionController@store')->name('auction.store');
Route::get('auction/{auction}', 'AuctionController@show')->name('auction.show');
Route::get('auction/{auction}/edit', 'AuctionController@edit')->name('auction.edit');
Route::put('auction/{auction}', 'AuctionController@update')->name('auction.update');
Route::delete('auction/{auction?}', 'AuctionController@destroy')->name('auction.destroy');

/*
 * Item
 */

Route::get('item/{auction}', 'ItemController@index')->name('item.index');
Route::get('item/{auction}/create', 'ItemController@create')->name('item.create');
Route::post('item/{auction}', 'ItemController@store')->name('item.store');
Route::get('item/{auction}/{item}', 'ItemController@show')->name('item.show');
Route::get('item/{auction}/{item}/edit', 'ItemController@edit')->name('item.edit');
Route::put('item/{auction}/{item}', 'ItemController@update')->name('item.update');
Route::delete('item/{auction}/{item?}', 'ItemController@destroy')->name('item.destroy');

/*
 * Bid
 */

Route::get('bid/{auction}/{item}', 'BidController@index')->name('bid.index');
Route::get('bid/{auction}/{item}/create', 'BidController@create')->name('bid.create');
Route::post('bid/{auction}/{item}', 'BidController@store')->name('bid.store');
Route::get('bid/{auction}/{item}/{amount}', 'BidController@show')->name('bid.show');
Route::get('bid/{auction}/{item}/{amount}/edit', 'BidController@edit')->name('bid.edit');
Route::put('bid/{auction}/{item}/{amount}', 'BidController@update')->name('bid.update');
Route::delete('bid/{auction}/{item}/{amount?}', 'BidController@destroy')->name('bid.destroy');

/*
 * User
 */

Route::get('user', 'UserController@index')->name('user.index');
Route::get('user/create', 'UserController@create')->name('user.create');
Route::post('user', 'UserController@store')->name('user.store');
Route::get('user/{user}', 'UserController@show')->name('user.show');
Route::get('user/{user}/edit', 'UserController@edit')->name('user.edit');
Route::put('user/{user}', 'UserController@update')->name('user.update');
Route::delete('user/{user?}', 'UserController@destroy')->name('user.destroy');

/*
 * Category
 */

Route::get('category', 'CategoryController@index')->name('category.index');
Route::get('category/create', 'CategoryController@create')->name('category.create');
Route::post('category', 'CategoryController@store')->name('category.store');
Route::get('category/{category}', 'CategoryController@show')->name('category.show');
Route::get('category/{category}/edit', 'CategoryController@edit')->name('category.edit');
Route::put('category/{category}', 'CategoryController@update')->name('category.update');
Route::delete('category/{category?}', 'CategoryController@destroy')->name('category.destroy');
