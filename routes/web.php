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

Route::get('/', function () {
    if (\Auth::check()) {
        return redirect('/admin/dashboard');
    }
    return view('auth.login');
});

Route::get('/callback', 'SheetController@callback')->name('callback');

Route::get('product-export', 'ProductController@productExport')->name('product-export');


Route::get('screen-lock/{currtime}/{id}/{randnum}', 'NoMiddlewareController@screenlock')->name('screenlock');

Route::post('payment-response','CallbackController@response')->name('payment-response');
Route::get('/get-payment-status','CallbackController@sucess')->name('get-payment-status');
Route::get('/get-payment-status-failed','CallbackController@failed')->name('get-payment-status-failed');
    	  


Auth::routes(['verify' => true]);

Route::group(['middleware' => 'prevent-back-history'],function(){
	Route::group(['middleware' => ['auth']], function () {


		Route::get('payment-system', 'PaymentController@paymentSystem')->name('payment-system');
		Route::post('addtocart',  'CartController@Addtocart');
	    Route::get('viewcart',  'CartController@viewcart')->name('viewcart');
	    Route::get('itemremove/{id}',  'CartController@itemremove');
	    Route::post('updateCart',  'CartController@updateCart')->name('updateCart');
	    Route::get('checkout',  'CartController@checkout')->name('checkout');
	    Route::post('makePayment',  'PaymentController@makePayment')->name('makePayment');

	   	

		Route::get('/logout', 'AdminController@logout')->name('logout');
		Route::group(['prefix' => 'admin'], function () {
	        Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');
			Route::get('/edit-profile', 'AdminController@editprofile')->name('edit-profile');
			Route::post('/change-password', 'AdminController@changePassword')->name('change-password');
			Route::post('/update-profile', 'AdminController@updateProfile')->name('update-profile');
			Route::get('need-help', 'NoMiddlewareController@needhelp')->name('need-help');

	        Route::get('app-setting', 'AppsettingController@appSetting')->name('app-setting');
	        Route::post('app-setting-update', 'AppsettingController@appSettingUpdate')->name('app-setting-update');

			Route::resource('permissions','PermissionController');
	        Route::get('permission-delete/{id}','PermissionController@permissionDelete')->name('permission-delete');
	        Route::resource('roles','RoleController');
	        Route::get('role-delete/{id}','RoleController@roleDelete')->name('role-delete');

	        Route::get('users-list', 'UserController@users')->name('users-list');
	        Route::get('add-user', 'UserController@adduser')->name('user-create');
	        Route::get('edit-user/{app_key}', 'UserController@edituser')->name('user-edit');
	        Route::get('view-user/{app_key}', 'UserController@viewuser')->name('user-view');
	        Route::post('saveuser', 'UserController@saveuser')->name('user-save');
	        Route::get('delete-user/{app_key}', 'UserController@deleteuser')->name('user-delete');
	        Route::post('actionUsers', 'UserController@actionUsers')->name('user-action');
	        Route::post('update-status', 'UserController@updateStatus')->name('update-status');


	         // Boxes Managament//
            Route::get('box', 'BoxController@boxes')->name('box');   
            Route::get('add-box', 'BoxController@addbox')->name('add-box');
            Route::get('edit-box/{id}', 'BoxController@editbox')->name('edit-box');
            Route::post('savebox', 'BoxController@savebox')->name('box-save');
            Route::post('assigneBoxId', 'BoxController@assigneBoxId')->name('assigneBoxId');
            Route::post('save-assignebox', 'BoxController@saveAssigneBox')->name('save-assignebox');


             // product Managament//
            Route::get('products', 'ProductController@products')->name('products');   
            Route::get('add-product', 'ProductController@addproduct')->name('add-product');
            Route::get('edit-product/{id}', 'ProductController@editproduct')->name('edit-product');
            Route::post('saveproduct', 'ProductController@saveproduct')->name('product-save');
            Route::get('delete-product/{id}', 'ProductController@deleteproduct')->name('delete-product');
            Route::post('product-import', 'ProductController@productImport')->name('product-import');
           


	        Route::post('import-sheet', 'SheetController@importSheet')->name('import-sheet');







        
        });

    
	});

});