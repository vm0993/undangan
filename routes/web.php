<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'web'], function () {
    //Route::auth();
    Route::get(
        '/',
        [
        'as' => 'login',
        'middleware' => ['web'],
        'uses' => 'Auth\LoginController@showLoginForm']
    );
    //Route::get('accept-email-invitation/{remember_token}','EmailVerificationController@setVerificationStatus')->name('accept-email-invitation');
    Route::get(
        'login',
        [
            'as' => 'login',
            'middleware' => ['web'],
            'uses' => 'Auth\LoginController@showLoginForm']
    );

    Route::get(
        'locked',
        [
            'as' => 'locked',
            'middleware' => ['web'],
            'uses' => 'Auth\LoginController@locked']
    );

    Route::post(
        'login',
        [
            'as' => 'login',
            'middleware' => ['web'],
            'uses' => 'Auth\LoginController@login']
    );

    Route::get(
        'logout',
        [
            'as' => 'logout',
            'uses' => 'Auth\LoginController@logout']
    );

});

Auth::routes(['verify' => true]);

Route::group( ['middleware' => ['auth','verified']], function() {
    //Dashboard
    Route::group(['prefix' => 'dashboard'], function() {
        Route::get('/','HomeController@index')->name('dashboard');
    });

    Route::group(['prefix' => 'master'], function() {
        Route::group(['prefix' => 'tamu'], function() {
            Route::get('/','TamuController@index')->name('master.tamu');
            Route::match(['get', 'post'],'/{sistem_id}/undangan', 'TamuController@addTamu')->name('master.tamu.create');
            Route::match(['get', 'put'],'/{sistem_id}/undangan/{id}/update', 'TamuController@editTamu')->name('master.tamu.update');

            Route::match(['get', 'post'],'/1/import','TamuController@tamuUpload')->name('master.tamu.upload');
        });
    });

    Route::group(['prefix' => 'invitation'], function() {
        Route::get('/','InvitationController@index')->name('invitation');
        Route::match(['get', 'post'],'/{sistem_id}/tamu', 'InvitationController@addUndangan')->name('invitation.create');
        Route::match(['get', 'put'],'/{sistem_id}/tamu/{id}/update', 'InvitationController@editUndangan')->name('invitation.update');
        //Cetak
        Route::get('/{id}/pdf','InvitationController@cetakUndangan')->name('invitation.pdf');
    });

    Route::group(['prefix' => 'monitoring'], function() {
        Route::get('/','HomeController@index')->name('monitoring');
    });
});