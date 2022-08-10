<?php

use Illuminate\Support\Facades\Route;

Route::prefix('artist')->namespace('Artist')->name('artist.')->group(function () {
    Route::get('/login', 'Auth\AuthController@showLoginForm')->name('login_form');
    Route::post('/login', 'Auth\AuthController@login')->name('login');
    Route::get('forget-password', 'Auth\ForgotPasswordController@showForgetPasswordForm')->name('forget.password.get');
    Route::post('forget-password', 'Auth\ForgotPasswordController@submitForgetPasswordForm')->name('forget.password.post');
    Route::get('reset-password/{token}', 'Auth\ForgotPasswordController@showResetPasswordForm')->name('reset.password.get');
    Route::post('reset-password', 'Auth\ForgotPasswordController@submitResetPasswordForm')->name('reset.password.post');


    Route::middleware(['auth:artist'])->group(function () {
        Route::get('/', function () {
            return redirect()->route('artist.dashboard');
        });

        Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');
        Route::get('/logout', 'Auth\AuthController@logout')->name('logout');

        #artist profile routes
        Route::get('/profile', 'UserController@profile')->name('profile');
        Route::post('/profile/update', 'UserController@updateProfile')->name('profile.update');

        Route::get('chat', 'DialogController@chat')->name('chat');
        Route::get('chat/{dialog}', 'DialogController@chatMessages')->name('chat.messages');
        Route::get('read/chat/{dialog}', 'DialogController@readAll')->name('chat.messages.read');
        Route::get('chat-sidebar', 'DialogController@sidebar')->name('chat.sidebar');
        Route::post('chat/send-message/{dialog}', 'DialogController@sendMessage')->name('chat.send.message');

        Route::resource('course', 'CourseController')->name('*', 'course');

        Route::get('live-course', 'CourseController@listLiveCourses')->name('course.live.list');
        Route::post('live-course/store/{course}', 'CourseController@storeLiveCourse')->name('course.live.store');
        Route::get('live-course/show/{liveCourse}', 'CourseController@showLiveCourse')->name('course.live.show');
        Route::put('live-course/update/{liveCourse}', 'CourseController@updateLiveCourse')->name('course.live.update');
        Route::delete('live-course/delete/{liveCourse}', 'CourseController@deleteLiveCourse')->name('course.live.delete');

        Route::resource('artistAvailableTime', 'ArtistAvailableTimeController')->name('*', 'artistAvailableTime');
        Route::get('artistAvailableTime/single-date/{date}', 'ArtistAvailableTimeController@showSingleDateAvailableTimes')->name('artistAvailableTime.showSingleDateAvailableTimes');
        Route::post('artistAvailableTime/single-date/{date}', 'ArtistAvailableTimeController@updateSingleDateAvailableTimes')->name('artistAvailableTime.updateSingleDateAvailableTimes');
    });
});
