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
################# pagination count ##########
define('PAGINATION_COUNT',10);
#############################################

Route::group(["middleware" => "auth:admin","namespace" => "App\Http\Controllers\Admin"],function (){
    Route::get("/" , "DashboardController@index")->name("admin.dashboard"); // الرئيسيه
    ####################### begin languages route ##########################
    Route::group(["prefix" => "language"],function (){
        Route::get("/","languageController@index")->name("admin.language"); // عرض الكل اللغات
        Route::get("create","languageController@create")->name("admin.language.create"); // عمل فورم لاضافه لغه جديده
        Route::post("store","languageController@store")->name("admin.language.store");// لتخزين اللغات المدخله فى الداتا بيز
        Route::get("edit/{id}","languageController@edit")->name("admin.language.edit"); // لتعديل اليبانات فى الداتا بيز
        Route::post("update/{id}","languageController@update")->name("admin.language.update"); // لتحديث البيانات فى الداتا بيز
        Route::get("delete/{id}","languageController@destroy")->name("admin.language.destroy"); // لحذف لغه معينه من الداتا بيز
    });
    ####################### endOf languages route ##########################

    ####################### begin mainCategory route ##########################
    Route::group(["prefix" => "mainCategory"],function (){
        Route::get("/","mainCategoryController@index")->name("admin.mainCategory"); // عرض الكل الاقسام الرئيسيه
        Route::get("create","mainCategoryController@create")->name("admin.mainCategory.create"); // عمل فورم لاضافه قسم جديده
        Route::post("store","mainCategoryController@store")->name("admin.mainCategory.store");// لتخزين الاقسام المدخله فى الداتا بيز
        Route::get("edit/{id}","mainCategoryController@edit")->name("admin.mainCategory.edit"); // لتعديل اليبانات فى الداتا بيز
        Route::post("update/{id}","mainCategoryController@update")->name("admin.mainCategory.update"); // لتحديث البيانات فى الداتا بيز
        Route::get("delete/{id}","mainCategoryController@destroy")->name("admin.mainCategory.destroy"); // لحذف قسم معين من الداتا بيز
        Route::get("changeStatus/{id}","mainCategoryController@changeStatus")->name("admin.mainCategory.status"); // لتحديث حاله قسم معين من الداتا بيز
    });
    ####################### endOf mainCategory route ##########################

    ####################### begin vendors route ##########################
    Route::group(["prefix" => "vendor"],function (){
        Route::get("/","vendorController@index")->name("admin.vendor"); // عرض الكل المتاجر الرئيسيه
        Route::get("create","vendorController@create")->name("admin.vendor.create"); // عمل فورم لاضافه متجر جديده
        Route::post("store","vendorController@store")->name("admin.vendor.store");// لتخزين المتاجر المدخله فى الداتا بيز
        Route::get("edit/{id}","vendorController@edit")->name("admin.vendor.edit"); // لتعديل اليبانات فى الداتا بيز
        Route::post("update/{id}","vendorController@update")->name("admin.vendor.update"); // لتحديث البيانات فى الداتا بيز
        Route::get("delete/{id}","vendorController@destroy")->name("admin.vendor.destroy"); // لحذف متجر معين من الداتا بيز
        Route::get("changeStatus/{id}","vendorController@changeStatus")->name("admin.vendor.status"); // لتحديث حاله متجر معين من الداتا بيز
    });
    ####################### endOf vendors route ##########################
});
Route::group(["namespace" => "App\Http\Controllers\admin","middleware" => "guest:admin" ],function (){
    Route::get("getLogin","logincontroller@getLogin")->name("admin.getLogin");
    Route::post("login","logincontroller@login")->name("admin.login");
});
