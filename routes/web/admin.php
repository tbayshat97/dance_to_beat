<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin')->namespace('Admin')->name('admin.')->group(function () {
    Route::get('/login', 'Auth\AuthController@showLoginForm')->name('login_form');
    Route::post('/login', 'Auth\AuthController@login')->name('login');
    Route::get('forget-password', 'Auth\ForgotPasswordController@showForgetPasswordForm')->name('forget.password.get');
    Route::post('forget-password', 'Auth\ForgotPasswordController@submitForgetPasswordForm')->name('forget.password.post');
    Route::get('reset-password/{token}', 'Auth\ForgotPasswordController@showResetPasswordForm')->name('reset.password.get');
    Route::post('reset-password', 'Auth\ForgotPasswordController@submitResetPasswordForm')->name('reset.password.post');



    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/', function () {
            return redirect()->route('admin.dashboard');
        });

        Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');
        Route::get('/logout', 'Auth\AuthController@logout')->name('logout');

        #Admin profile routes
        Route::get('/profile', 'UserController@profile')->name('profile');
        Route::post('/profile/update', 'UserController@updateProfile')->name('profile.update');
    });

    #Walkthrough routes
    Route::middleware(['auth:admin', 'permission:walkthrough management'])->group(function () {
        Route::resource('walkthrough', 'WalkthroughController')->name('*', 'walkthrough');
    });

    #Static pages routes
    Route::middleware(['auth:admin', 'permission:staticPage management'])->group(function () {
        Route::resource('staticPage', 'StaticPageController')->name('*', 'staticPage');
        #App Slider routes
        Route::resource('app-slider', 'MainSliderController')->name('*', 'app-slider');
    });

    #Roles routes
    Route::middleware(['auth:admin', 'permission:roles'])->group(function () {
        Route::get('roles/users', 'AdminRoleController@users')->name('roles.users');
        Route::get('roles/users/{user}/edit', 'AdminRoleController@usersEdit')->name('roles.users.edit');
        Route::put('roles/users/{user}/edit', 'AdminRoleController@usersUpdate')->name('roles.users.save');
        Route::resource('roles', 'AdminRoleController')->name('*', 'roles');
    });

    #Administration routes
    Route::middleware(['auth:admin', 'permission:admin management'])->group(function () {
        Route::resource('administration', 'UserController')->name('*', 'administration');
    });

    #Customers routes
    Route::middleware(['auth:admin', 'permission:customers management'])->group(function () {
        Route::resource('customer', 'CustomerController')->name('*', 'customer');
        Route::get('subscribers', 'CustomerController@subscribers')->name('customer.subscribers');
    });

    #Chats routes
    Route::middleware(['auth:admin', 'permission:chat management'])->group(function () {
        Route::get('chat', 'DialogController@chat')->name('chat');
        Route::get('chat/{dialog}', 'DialogController@chatMessages')->name('chat.messages');
        Route::get('read/chat/{dialog}', 'DialogController@readAll')->name('chat.messages.read');
        Route::get('chat-sidebar', 'DialogController@sidebar')->name('chat.sidebar');
        Route::post('chat/send-message/{dialog}', 'DialogController@sendMessage')->name('chat.send.message');
    });

    #Transactions routes
    Route::middleware(['auth:admin', 'permission:transactions management'])->group(function () {
        Route::resource('customerTransaction', 'CustomerTransactionController')->name('*', 'customerTransaction');
    });

    #Orders routes
    Route::middleware(['auth:admin', 'permission:transactions management'])->group(function () {
        Route::resource('customerTransaction', 'CustomerTransactionController')->name('*', 'customerTransaction');
    });

    #Dances routes
    Route::middleware(['auth:admin', 'permission:dances management'])->group(function () {
        Route::resource('dance', 'DanceController')->name('*', 'dance');
    });

    #Notifications routes
    Route::middleware(['auth:admin', 'permission:notifications management'])->group(function () {
        Route::post('send-notification', 'SendNotificationController@send')->name('send-notification');
        Route::get('send-notification', 'SendNotificationController@sendNotificationPage')->name('send-notification-page');
    });

    Route::middleware(['auth:admin', 'permission:subscriptions management'])->group(function () {
        Route::resource('subscription', 'SubscriptionController')->name('*', 'subscription');
    });

    Route::middleware(['auth:admin', 'permission:artists management'])->group(function () {
        Route::resource('artist', 'ArtistController')->name('*', 'artist');
    });

    Route::middleware(['auth:admin', 'permission:appointments management'])->group(function () {
        Route::resource('appointment', 'AppointmentController')->name('*', 'appointment');
    });

    Route::middleware(['auth:admin', 'permission:coupons management'])->group(function () {
        Route::resource('coupon', 'CouponController')->name('*', 'coupon');
    });

    Route::middleware(['auth:admin', 'permission:orders management'])->group(function () {
        Route::resource('order', 'OrderController')->name('*', 'order');
    });

    Route::middleware(['auth:admin', 'permission:courses management'])->group(function () {
        Route::resource('course', 'CourseController')->name('*', 'course');
        Route::get('live-course', 'CourseController@listLiveCourses')->name('course.live.list');
        Route::post('live-course/store/{course}', 'CourseController@storeLiveCourse')->name('course.live.store');
        Route::get('live-course/show/{liveCourse}', 'CourseController@showLiveCourse')->name('course.live.show');
        Route::put('live-course/update/{liveCourse}', 'CourseController@updateLiveCourse')->name('course.live.update');
        Route::delete('live-course/delete/{liveCourse}', 'CourseController@deleteLiveCourse')->name('course.live.delete');
    });

    Route::middleware(['auth:admin', 'permission:reviews management'])->group(function () {
        Route::get('review/courses', 'ReviewController@courses')->name('courses-review');
        Route::get('review/artists', 'ReviewController@artists')->name('artists-review');
        Route::get('review/courses/{course}', 'ReviewController@showCourse')->name('courses-review.show');
        Route::get('review/artists/{artist}', 'ReviewController@showArtist')->name('artists-review.show');
    });

    Route::middleware(['auth:admin', 'permission:reports management'])->group(function () {
        Route::get('report/orders', 'ReportController@orders')->name('orders-report');
        Route::get('report/bookings', 'ReportController@bookings')->name('bookings-report');
        Route::get('report/subscriptions', 'ReportController@subscriptions')->name('subscriptions-report');
    });
});
