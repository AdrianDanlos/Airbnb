<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
// Route::get('bookables', 'Api\BookableController@index');
// Route::get('bookable/{id}', 'Api\BookableController@show');

//:apiResource method creates all the routes by default. See php artisan route:list.
Route::apiResource('bookables', 'Api\BookableController')->only(['index', 'show']);

Route::get('bookables/{bookable}/availability', 'Api\BookableAvailabilityController')->name('bookables.availability.show');
Route::get('bookables/{bookable}/reviews', 'Api\BookableReviewController')->name('bookables.reviews.index');
Route::get('bookables/{bookable}/price', 'Api\BookablePriceController')->name('bookables.price.show');

Route::get('/booking-by-review/{reviewKey}', 'Api\BookingByReviewController')->name('booking.by-review.show');

Route::apiResource('reviews', 'Api\ReviewController')->only(['show', 'store']);

Route::post('checkout', 'Api\CheckoutController')->name('checkout');

Route::get('bookables/countries/{country}', 'Api\BookableCountryController');

//Public API calls
Route::get('countries', 'Api\GetAllCountriesController')->name('get-countries');




