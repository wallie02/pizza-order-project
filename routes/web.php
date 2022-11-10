<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserlistController;
use App\Http\Controllers\User\AjaxController;
use App\Http\Controllers\User\UserController;


//pizzaordersystem..

//login , register

 Route::middleware(['admin_auth'])->group(function(){

    Route::redirect('/', 'loginpage');
    Route::get('loginpage',[AuthController::class,'loginPage'])->name('auth#loginPage');
    Route::get('registerpage',[AuthController::class,'registerPage'])->name('auth#registerPage');

 });




Route::middleware(['auth'])->group(function () {

//dashboard => ( check user or admin )
Route::get('dashboard', [AuthController::class, 'dashboardPage'])->name('dashboard');


//admin
Route::middleware(['admin_auth'])->group(function() {
    //category
    Route::prefix('category')->group(function (){
    Route::get('list',[CategoryController::class,'lists'])->name('category#list');
    Route::get('create/page',[CategoryController::class,'createPage'])->name('category#createPage');
    Route::post('create',[CategoryController::class,'create'])->name('category#create');
    //delete
    Route::get('delete/{id}',[CategoryController::class,'delete'])->name('category#delete');
    //edit
    Route::get('edit/{id}',[CategoryController::class,'edit'])->name('category#edit');
    //edit->hash_update
    Route::post('update',[CategoryController::class,'update'])->name('category#update');
    });

    //admin account
    Route::prefix('admin')->group(function () {
        //changepassword
        Route::get('password/changePage',[AdminController::class,'changePasswordPage'])->name('admin#changePasswordPage');
        Route::post('changePassword',[AdminController::class,'changePassword'])->name('admin#changePassword');

        //account profile details
        Route::get('admin/profileDetails',[AdminController::class,'profileDetails'])->name('admin#profileDetails');
        //edit profile
        Route::get('editProfile',[AdminController::class,'profileEdit'])->name('admin#profileEdit');
        //update profile
        Route::post('updateProfile/{id}',[AdminController::class,'profileUpdate'])->name('admin#profileUpdate');

        //admins list
        Route::get('adminlist',[AdminController::class,'adminList'])->name('admin#adminList');
        Route::get('adminlistDelete/{id}',[AdminController::class,'adminListDelete'])->name('admin#adminListDelete');
        Route::get('changeRole/{id}',[AdminController::class,'changeRole'])->name('admin#changeRole');
        Route::post('changeRole/{id}',[AdminController::class,'changeRoleUp'])->name('admin#changeRoleUp');
        Route::get('ajax/change/role',[AdminController::class,'ajaxChangeRole'])->name('admin#ajaxChangeRole');

    });


    //Product
    Route::prefix('product')->group(function () {
        Route::get('productList',[ProductController::class,'productList'])->name('product#productList');
        Route::get('createPizzaPage',[ProductController::class,'createPizza'])->name('product#createPizza');
        Route::post('createPizzaPage',[ProductController::class,'create'])->name('product#create');
        Route::get('deletePizza/{id}',[ProductController::class,'deletePizza'])->name('product#deletePizza');
        Route::get('editPizza/{id}',[ProductController::class,'editPizza'])->name('product#editPizza');
        Route::get('updatePage/{id}',[ProductController::class,'updatePagePizza'])->name('product#updatePagePizza');
        Route::post('updatePizza',[ProductController::class,'updatePizza'])->name('product#updatePizza');
    });

    //OrderList
    Route::prefix('order')->group(function () {
        Route::get('listPage',[OrderController::class,'orderListPage'])->name('order#orderListPage');
        Route::get('change/status',[OrderController::class,'orderchangeStatus'])->name('order#orderchangeStatus');
        Route::get('ajax/change/status',[OrderController::class,'ajaxChangeStatus'])->name('order#ajaxChangeStatus');
        Route::get('list/info/{orderCode}',[OrderController::class,'listInfo'])->name('order#listInfo');
    });

    //user list
    Route::prefix('user')->group(function () {
        Route::get('list',[UserlistController::class,'userList'])->name('admin#userList');
        Route::get('ajax/userchange/role',[UserlistController::class,'ajaxuserChangeRole'])->name('admin#ajaxuserChangeRole');
        Route::get('delete/{id}',[UserlistController::class,'deleteUser'])->name('userlist#delete');

        Route::get('updatePage/{id}',[UserlistController::class,'updatePage'])->name('userlist#updatePage');
        Route::post('updateAcc',[UserlistController::class,'updateAcc'])->name('userlist#updateAcc');

    });

    //contact list
    Route::prefix('contactlist')->group(function () {
         Route::get('listpage',[ContactController::class,'contactList'])->name('admin#contactList');
         Route::get('delete/{id}',[ContactController::class,'deleteContact'])->name('contact#deleteContact');

    });

});



//user
//home
Route::group(['prefix'=>'user','middleware'=>'user_auth'],function(){
        Route::get('/homePage',[UserController::class,'userhomepage'])->name('user#home');
        Route::get('/filter/{id}',[UserController::class,'userFilter'])->name('user#userFilter');
        Route::get('/history',[UserController::class,'userHistory'])->name('user#userHistory');

        //pizza details
         Route::prefix('pizza')->group(function () {
            Route::get('details/{id}',[UserController::class,'pizzaDetials'])->name('user#pizzaDetials');
        });

        //password
        Route::prefix('password')->group(function () {
            Route::get('changePass',[UserController::class,'changePasswordPage'])->name('user#changePasswordPage');
            Route::post('changePass',[UserController::class,'changeUserPassword'])->name('user#changeUserPassword');
        });

        //profile account
        Route::prefix('account')->group(function () {
            Route::get('userAccount',[UserController::class,'userAccountPage'])->name('user#userAccountPage');
            Route::post('changeUserAccount/{id}',[UserController::class,'userAccountChange'])->name('user#userAccountChange');
        });

        Route::prefix('ajax')->group(function () {
            Route::get('pizzalist',[AjaxController::class,'pizzaAjaxlist'])->name('user#pizzaAjaxlist');
            Route::get('cart',[AjaxController::class,'addtoCart'])->name('user#addtoCart');
            Route::get('order',[AjaxController::class,'orderAjax'])->name('user#orderAjax');
            Route::get('clear/cart',[AjaxController::class,'cartClear'])->name('user#cartClear');
            Route::get('clear/eachRow',[AjaxController::class,'clearProductRow'])->name('user#clearProductRow');
            Route::get('increase/viewCount',[AjaxController::class,'increaseViewCount'])->name('user#increaseViewCount');
        });

        //cart
        Route::prefix('cart')->group(function () {
            Route::get('cartList',[UserController::class,'cartList'])->name('user#cartList');

        });

        //contact
        Route::prefix('contact')->group(function () {
            Route::get('sendbox',[ContactController::class,'contactPage'])->name('user#contactPage');
            Route::post('sendcontact',[ContactController::class,'sendContact'])->name('user#sendContact');

        });
    });

});

Route::get('webTest',function(){
    $data = [
        'message' => 'this is web testing'
    ];
    return response()->json($data, 200);
});

// localhost::8000/webTest
