<?php

use App\Http\Controllers\Admin\Auth\AdminAuthController;
use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Admin\Booking\BookingController;
use App\Http\Controllers\Admin\Hostel\HostelController;
use App\Http\Controllers\Admin\Localization\BackendLanguageController;
use App\Http\Controllers\Admin\Localization\ChangeLanguageController;
use App\Http\Controllers\Admin\Localization\LanguageController;
use App\Http\Controllers\Admin\Role\RoleAndPermissionController;
use App\Http\Controllers\Admin\Rooms\RoomController;
use App\Http\Controllers\Admin\Rooms\SeatController;
use App\Http\Controllers\Admin\Settings\MaintenanceModeController;
use App\Http\Controllers\Admin\User\UserController;
use Illuminate\Support\Facades\Route;
use Stichoza\GoogleTranslate\GoogleTranslate;


Route::prefix('admin')->name('admin.')->group(function(){
    Route::controller(AdminAuthController::class)->group(function(){
        Route::post('/forget-password','forgetPassword')->name('forget_password');
        Route::get('/reset-password','resetPasswordIndex')->name('reset_password');
        Route::post('/reset-password','resetPasswordUpdate')->name('reset_password');
    });
    Route::controller(AdminLoginController::class)->group(function(){
        Route::get('/login','login')->name('login');
        Route::post('/login','handleLogin')->name('login');
        Route::get('/logout','handleLogout')->name('logout');
        Route::get('/dashboard','index')->name('index')->middleware('admin','adminStatusCheck');
        Route::get('/admin-profile','adminProfile')->name('profile')->middleware('admin','adminStatusCheck');
        Route::post('/update-basic-info','updateBasicInfo')->name('basicInfo')->middleware('admin','adminStatusCheck');
        Route::post('/update-password','updatePassword')->name('update_basic_info')->middleware('admin','adminStatusCheck');
    });

    Route::middleware('admin','adminStatusCheck')->group(function(){
        //user routes
        Route::resource('user',UserController::class)->except(['craete','show']);
        Route::controller(UserController::class)->name('user.')->prefix('user')->group(function () {
            Route::get('/update/status/{id}/{status}', 'updateStatus')->name('user_status');
        });

        //roles and permissions
        Route::resource('role',RoleAndPermissionController::class)->except(['craete','show']);
        Route::controller(RoleAndPermissionController::class)->name('role.')->prefix('role')->group(function () {
            Route::get('/get-user-permissions/{id}','getUserPermission')->name('getUserPermission');
            Route::post('/give-user-permissions','giveUserPermission')->name('giveUserPermission');
        });

        //language controller
        Route::resource('language',LanguageController::class)->except(['craete','show']);
        Route::controller(LanguageController::class)->name('language.')->prefix('language')->group(function () {
            Route::get('/update/status/{id}/{status}', 'updateStatus')->name('language_status');
        });

        //backend language controller
        Route::resource('backend/language',BackendLanguageController::class,['as'=>'backend'])->except(['craete','show','edit','distroy']);
        Route::controller(BackendLanguageController::class)->name('backend.language.')->prefix('backend/language')->group(function () {
            Route::post('/store/translate/string', 'storeTranslateString')->name('storeTranslateString');
            Route::post('/store/apikey', 'storeApikey')->name('storeApikey');
        });
        Route::get('/change/language/{lang}',ChangeLanguageController::class)->name('changeLanguage');

        //settings
        Route::prefix('settings')->name('settings.')->group(function(){
            Route::get('/maintenance-mode',[MaintenanceModeController::class,'maintenanceMode'])->name('server.maintenanceMode');
            Route::post('/maintenance-mode-on',[MaintenanceModeController::class,'maintenanceModeOn'])->name('server.maintenanceModeOn');
            // Route::get('/server/down',[MaintenanceModeController::class,'down'])->name('server.down');
            Route::get('/server/up',[MaintenanceModeController::class,'up'])->name('server.up');
            Route::get('/secret-code/delete/{id}',[MaintenanceModeController::class,'destroy'])->name('secret-code.delete');
            Route::get('/secret-code/delete-all',[MaintenanceModeController::class,'destroyAll'])->name('secret-code.delete-all');
        });

        Route::get('/translate-string',function(){
            $data = [];
            $langs = getLangs();
            foreach($langs as $lang){
                $darr =  GoogleTranslate::trans(request()->tdata, $lang->lang, 'en');
                array_push($data,$darr);
            }
            return [
                'tdata'=>$data,
                'langs'=>$langs
            ];
        })->name('translateString');


        /** Hostel Start */

        Route::resource('hostel',HostelController::class)->except('create');
        Route::controller(HostelController::class)->prefix('hostel')->group(function(){
            Route::get('update/status/{id}/{status}','updateStatus');
        });

        /** Hostel End */

        /** Room Start */

        Route::controller(RoomController::class)->group(function(){
            Route::get('/rooms','index')->name('room.index');
            Route::get('/rooms/create','create')->name('room.create');
            Route::post('/rooms/store','store')->name('room.store');
            Route::get('/rooms/get-building-details/{hostel_id}','getHostelDetails');
            Route::get('/rooms/{id}/edit','edit')->name('room.edit');
            Route::put('/rooms/update/{id}','update')->name('room.update');
            Route::get('rooms/update/status/{id}/{status}','updateStatus');
            Route::delete('rooms/delete/{id}','destroy');
        });

        /** Room End */

        /** Seats End*/
        Route::resource('/seats',SeatController::class);
        /** Seats End */

        /** Booking Start */
        Route::resource('/booking',BookingController::class);
        Route::post('/get/available/seats',[BookingController::class,'getAvailableSeats'])->name('booking.getAvailableSeats');
        /** Booking End */
    });
});


