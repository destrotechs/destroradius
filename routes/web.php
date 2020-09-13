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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home/allcustomers','HomeController@getAllCustomers')->name('allcustomers');
Route::get('/home/newcustomers','HomeController@getNewCustomer')->name('newcustomer');
Route::get('/home/editcustomer','HomeController@fetchCustomer')->name('editcustomer');
Route::get('/home/manage','HomeController@getCleanStale')->name('get.cleanstale');
Route::get('/home/listnas','HomeController@getNasList')->name('listnas');
Route::get('/home/newnas','HomeController@getNewNas')->name('newnas');
Route::get('/home/editnas/{id}','HomeController@getEditNas')->name('editnas');
Route::get('/home/newnas','HomeController@getNewNas')->name('newnas');
Route::get('/home/newlimitattribute','HomeController@getNewLimitAttr')->name('newlimitattr');
Route::get('/home/userlimitgroups','HomeController@getUserlimitGroups')->name('userlimitgroups');
Route::get('/home/editcustomer/{id}','HomeController@getSpecificCustomer')->name('specificcustomer');
Route::get('/home/allpayments','HomeController@getAllPayments')->name('allpayments');
Route::get('/home/initiatepayment','HomeController@getInitializePayment')->name('initiatepayment');
Route::get('/home/lastconnection-attempts','HomeController@getLastConnectionAtt')->name('lastconnatt');
Route::get('/home/userconnectivity','HomeController@getUserConnectivity')->name('customerconnectivity');
Route::get('/home/Onlinecustomers','HomeController@getOnlineusers')->name('onlineusers');
Route::get('/home/useraccounting','HomeController@getUserAccounting')->name('useraccounting');
Route::get('/home/ipaccounting','HomeController@getIpAccounting')->name('ipaccounting');
Route::get('/home/nasaccounting','HomeController@getNasAccounting')->name('nasaccounting');
Route::get('/home/plans','HomeController@getPlans')->name('plans');
Route::get('/markAsRead', function(){

	auth()->user()->unreadNotifications->markAsRead();

	return redirect()->back();

})->name('mark');
Route::get('/home/deleteacctrec','HomeController@getDeleteRec')->name('deleteacctrec');
Route::get('/home/operators','HomeController@getOperators')->name('operators');
Route::get('/home/operator/{id}','HomeController@editOperator')->name('editoperator');
Route::get('/home/operator/delete/{id}','HomeController@deleteOperator')->name('deleteop');
Route::get('/home/editplan/{id}','HomeController@getPlanEdit')->name('editplan');
Route::get('/home/deleteplan/{id}','HomeController@deletePlan')->name('deleteplan');
Route::get('/home/servicestatus','HomeController@getServiceStatus')->name('servicestatus');
Route::get('/home/userlimits','HomeController@getUserLimits')->name('userlimits');
//post routes
Route::post('/home/newcustomer','HomeController@postNewCustomer')->name('post.newcustomer');
Route::post('/home/fetchcustomer','HomeController@postFetchCustomer')->name('fetchcustomertoedit');
Route::post('/home/newnas','HomeController@postNewNas')->name('savenewnas');
Route::post('/home/posteditednas','HomeController@postEditedNas')->name('saveeditednas');
Route::post('/home/newlimit','HomeController@postNewLimit')->name('postnewlimit');
Route::post('/home/newgrouplimit','HomeController@postNewLimitGroup')->name('postnewgrouplimit');
Route::post('/initiatepayment','paymentController@postPayToGetCredentials')->name('user.post.credentials');
Route::post('/home/useraccounting','HomeController@userAccounting')->name('fetchcustomeraccounting');
Route::post('/home/ipaccounting','HomeController@ipAccounting')->name('fetchipaccounting');
Route::post('/home/nasaccounting','HomeController@nasAccounting')->name('fetchnasaccounting');
Route::post('/home/plans','HomeController@postPlan')->name('admin.post.plan');
Route::post('/home/deleteacctrec','HomeController@postDeleteAcctRec')->name('deletecustomeracctrec');
Route::post('/home/operators','HomeController@postOperator')->name('postoperator');
Route::post('/home/editoperator','HomeController@postEditOperator')->name('posteditoperator');
Route::post('/home/editplan','HomeController@postEditPlan')->name('posteditplan');
Route::post('/home/editedcustomer','HomeController@saveCustomerChanges')->name('saveeditedcustomer');
Route::post('/home/cleanstaleconn','HomeController@cleanStaleConn')->name('post.cleanstale');
Route::post('/home/testconn','HomeController@postTestConn')->name('testconn');