<?php

use Illuminate\Support\Facades\Route;

Route::prefix('customer')->namespace('API\Customer')->middleware('apilogger')->group(function () {

    # Auth Routes
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::post('verify-sms', 'AuthController@verifySMS');
    Route::post('resend-sms', 'AuthController@resendSMS');
    Route::post('forget-password', 'AuthController@forgetPassword');
    Route::post('reset-password', 'AuthController@resetPassword');
    Route::post('facebook/login', 'AuthController@facebookLogin');
    Route::post('google/login', 'AuthController@googleLogin');
    Route::post('apple/login', 'AuthController@appleLogin');

    # public
    Route::get('static-pages', 'StaticPageController@list');
    Route::get('walkthrough', 'WalkthroughController@list');
    Route::get('main-slider', 'MainSliderController@list');
    Route::get('dance', 'DanceController@list');

    Route::middleware(['api', 'multiauth:customer'])->group(function () {
        # profile
        Route::post('social/link', 'AuthController@linkSocialAccount');
        Route::post('change-password', 'AuthController@changePassword');
        Route::get('profile', 'AuthController@profile');
        Route::post('profile', 'AuthController@updateProfile');
        Route::post('profile/update-username', 'AuthController@updateUsername');

        Route::get('profile/check-if-need-to-update-phone', 'AuthController@checkIfNeedToUpdatePhoneNumber');

        # auth
        Route::get('logout/other-devices', 'AuthController@logoutFromOtherDevices');
        Route::get('logout', 'AuthController@logout');

        # notification & availability
        Route::get('notification', 'CustomerNotificationController@list');
        Route::get('notification/delete-all', 'CustomerNotificationController@deleteAll');
        Route::delete('notification/{customerNotification}', 'CustomerNotificationController@destroy');
        Route::post('receive-notification', 'CustomerNotificationController@receiveNotification');

        # chat
        Route::get('chat/users', 'ChatController@users');
        Route::get('chat/dialog-messages/{dialog}', 'ChatController@dialogMessages');
        Route::post('admin/send-message', 'DialogMessageController@sendMessage');

        # customer interests
        Route::post('customerInterest/add', 'CustomerInterestController@store');

        # subscription
        Route::get('subscription', 'SubscriptionController@list');

        # artist
        Route::get('artist', 'ArtistController@list');
        Route::get('artist/{artist}', 'ArtistController@show');

        # course
        Route::get('course/live', 'CourseController@live');
        Route::get('course/recorded', 'CourseController@recorded');
        Route::get('course/recommended', 'CourseController@recommended');
        Route::get('course/trending', 'CourseController@trending');
        Route::get('course/{course}', 'CourseController@show');

        # favorite
        Route::get('favorite/courses', 'FavoriteController@favoriteCourses');
        Route::get('favorite/artists', 'FavoriteController@favoriteArtists');
        Route::post('favorite/add-course/{course}', 'FavoriteController@addCourse');
        Route::post('favorite/add-artist/{artist}', 'FavoriteController@addArtist');
        Route::post('favorite/delete', 'FavoriteController@delete');

        # search
        Route::get('search/attributes', 'SearchController@searchAttributes');
        Route::get('search', 'SearchController@search');

        # subscription
        Route::post('subscribe/{subscription}', 'CustomerSubscriptionController@subscribe');

        # order & checkout
        Route::get('order', 'OrderController@list');
        Route::get('order/search', 'OrderController@search');
        Route::post('order/{course}', 'OrderController@store');
        Route::get('order/{order}', 'OrderController@show');

        # payment
        Route::post('getCheckoutId', 'HyperpayGatewayController@getCheckoutId')->name('getCheckoutId');
        Route::get('getPaymentStatus', 'HyperpayGatewayController@getPaymentStatusApi');

        # appointments
        Route::get('appointment', 'AppointmentController@list');
        Route::post('appointment/{artist}', 'AppointmentController@book');
        Route::post('appointment/artist/available-time', 'AppointmentController@artistAvailableTime');

        # reviews
        Route::post('review', 'ReviewController@store');
        Route::post('review/is-review', 'ReviewController@checkReview');

        # dashboard
        Route::get('dashboard', 'DashboardController@dashboard');
    });
});
