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


Route::get('/', 'HomeController@index');

Route::get('/certificate', 'HomeController@certificate');

Route::get('/blog', 'HomeController@blog');
Route::get('/blog-detail/{slug?}', 'HomeController@blogDetail');
Route::get('/latest-blogs', 'HomeController@getLatestBlogs');

Route::get('/contact', function () {return view('front-user.pages.contact');});
Route::post('/contact', 'HomeController@contact');

Route::get('/faq', 'HomeController@faqs');


//login/register
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login')->name('login.submit');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/signup', 'Auth\RegisterController@showSignupForm')->name('signup');
Route::post('/signup', 'Auth\RegisterController@register')->name('register.submit');
Route::get('verify-user/{token}', 'Auth\RegisterController@verify_user');
Route::get('send-verification-mail/{email}','Auth\RegisterController@sendVerificationMail');

//forget password
Route::get('/forgot-password', function () {return view('auth.forgot-password');});
Route::post('/forgot-password', 'Auth\LoginController@forgetPassword');
Route::get('/password/reset/{token}', function ($token) {
    return view('auth.new-password')->with(['token' => $token]);
});
Route::post('/password/reset/{token}', 'Auth\LoginController@updateForgotPassword');

//social login
Route::get('login/{provider?}', 'Auth\RegisterController@redirectToProvider');
Route::get('callback/{provider}', 'Auth\RegisterController@handleProviderCallback');

//after login

Route::middleware('auth')->group(function () {

    Route::get('/notifications', 'UserController@notifications');
    
    Route::get('/change-password', function () {return view('front-user.common.change-password');});
    Route::post('/change-password', 'UserController@changePassword');

    Route::get('/my-profile', function () {return view('front-user.common.my-profile');});
    Route::post('/my-profile', 'UserController@updateProfile');

    // Route::post('/send-message', 'MessageController@sendMessage');
    // Route::get('/messages', 'MessageController@messages');
    // Route::get('/get-chat-detail/{chat_id}', 'MessageController@getChatDetail');
    // Route::post('/reply-message', 'MessageController@replyMessage');


    Route::get('/users', 'MessagesController@users');
    Route::get('/load-latest-messages', 'MessagesController@getLoadLatestMessages');
    Route::post('/send', 'MessagesController@postSendMessage');
    Route::get('/fetch-old-messages', 'MessagesController@getOldMessages');

    Route::get('/meetings', 'ZoomController@index');
    Route::get('/show-meeting/{meeting_id}', 'ZoomController@show');
    Route::get('/create-meeting', 'ZoomController@createMeeting');
    Route::post('/store-meeting', 'ZoomController@store');


});

//admin
Route::prefix('admin')->group(function() {
	Route::get('login','Auth\AdminLoginController@showLoginForm')->name('admin.login');
	Route::post('login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
	Route::get('logout', 'Auth\AdminLoginController@logout')->name('admin.logout');

	//forget password routes
	Route::get('forget-password', 'Auth\AdminLoginController@forgetPassword');
	Route::post('send-forget-password-link', 'Auth\AdminLoginController@sendForgetPasswordResetLink');
	Route::get('password-reset/{token}', function ($token) {
	    return view('admin.reset-password')->with(['token' => $token]);
	});
	Route::post('update-forget-password', 'Auth\AdminLoginController@updateAdminForgotPassword');

	
	Route::get('/', 'AdminController@index')->name('admin.dashboard');
	##Admin profile management Routes
    Route::get('/notifications', 'AdminController@notifications');
    Route::get('/profile', 'AdminController@profile')->name('admin.profile');
    Route::post('/update-admin-profile', 'AdminController@updateAdminProfile');
    Route::get('/change-password', 'AdminController@changePassword')->name('admin.change-password');
    Route::post('/update-admin-password', 'AdminController@updateAdminPassword');

    //Manage customers
    Route::get('/manage-customers', 'AdminController@manageCustomers');
    Route::get('/add-customer', 'AdminController@addCustomer');
    Route::post('/add-customer', 'AdminController@saveCustomer');
    Route::get('/edit-customer/{id?}', 'AdminController@editCustomer');
    Route::post('/edit-customer/{id?}', 'AdminController@updateCustomer');
    Route::post('/delete-customer', 'AdminController@deleteCustomer');

    //Manage rink operators
    Route::get('/manage-rink-operators', 'AdminController@manageRinkOperators');
    Route::get('/add-rink-operator', 'AdminController@addRinkOperator');
    Route::post('/add-rink-operator', 'AdminController@saveRinkOperator');
    Route::get('/edit-rink-operator/{id?}', 'AdminController@editRinkOperator');
    Route::post('/edit-rink-operator/{id?}', 'AdminController@updateRinkOperator');
    Route::post('/delete-rink-operator', 'AdminController@deleteRinkOperator');

    //Manage blogs
    Route::get('/manage-blogs', 'AdminController@manageBlogs');
    Route::get('/add-blog', 'AdminController@addBlog');
    Route::post('/add-blog', 'AdminController@saveBlog');
    Route::get('/edit-blog/{id?}', 'AdminController@editBlog');
    Route::post('/edit-blog/{id?}', 'AdminController@updateBlog');
    Route::post('/delete-blog', 'AdminController@deleteBlog');
    Route::post('/activate-deactivate-blog', 'AdminController@activateDeactivateBlog');

    //Manage faqs
    Route::get('/manage-faqs', 'AdminController@manageFaqs');
    Route::get('/add-faq', 'AdminController@addFaq');
    Route::post('/add-faq', 'AdminController@saveFaq');
    Route::get('/edit-faq/{id?}', 'AdminController@editFaq');
    Route::post('/edit-faq/{id?}', 'AdminController@updateFaq');
    Route::post('/delete-faq', 'AdminController@deleteFaq');
    Route::post('/activate-deactivate-faq', 'AdminController@activateDeactivateFaq');

    //Manage faq-topics
    Route::get('/manage-faq-topics', 'AdminController@manageFaqTopics');
    Route::get('/add-faq-topic', 'AdminController@addFaqTopic');
    Route::post('/add-faq-topic', 'AdminController@saveFaqTopic');
    Route::get('/edit-faq-topic/{id?}', 'AdminController@editFaqTopic');
    Route::post('/edit-faq-topic/{id?}', 'AdminController@updateFaqTopic');
    Route::post('/delete-faq-topic', 'AdminController@deleteFaqTopic');
    Route::post('/activate-deactivate-faq-topic', 'AdminController@activateDeactivateFaqTopic');

    //Manage pages
    Route::get('/manage-pages', 'AdminController@managePages');
    Route::get('/add-page', 'AdminController@addPage');
    Route::post('/add-page', 'AdminController@savePage');
    Route::get('/edit-page/{id?}', 'AdminController@editPage');
    Route::post('/edit-page/{id?}', 'AdminController@updatePage');
    Route::post('/delete-page', 'AdminController@deletePage');
    Route::post('/activate-deactivate-page', 'AdminController@activateDeactivatePage');

});


Route::get('/{slug?}', 'HomeController@cms');