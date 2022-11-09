<?php

use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\dashboard\ProductsController;
use App\Http\Controllers\Dashboard\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;


Route::group([
    'middleware' => ['auth','auth.type:admin,super-admin'],
    'as' => 'dashboard.',  //prefix for every name of route
    'prefix' => 'dashboard' //prefix for every route itself
], function () {

    Route::get('/', [DashboardController::class, 'index']); // route become /dashboard because the prefix proparite in group function
    //  ->name('dashboard'); // the name become dashboard.dashboard because the as proparite of group function  الخاصية as

    //Categories
    // Route::get('categories/{categor}',[CategoriesController::class,'show'])
    //     ->name('categories.show')
    //     ->where('category','/d+'); // /d+ تعني اي عدد من الانتجر
        // بهذه الطريقة الي انا عرفت فيها الشاو مستحيل يصير عندي error عشان قصة ترتيب الراوتس حتى لو حطيت التراش تحت
        //->except('show'); وبهذه الطريقة لازم استثي الشو من تعريف الريسورس

    Route::get('/categories/trash', [CategoriesController::class, 'trash'])
        ->name('categories.trash');

    Route::put('/categories/{category}/restore',[CategoriesController::class,'restore'])
        ->name('categories.restore');

    Route::delete('/categories/{category}/force-delete',[CategoriesController::class,'forceDelete'])
        ->name('categories.force-delete');

    Route::resource('/categories', CategoriesController::class);//->except('show'); //route becomes dashboard/categories //7 routes php artisan route:list
    //dashboard.categories.index
    //dashboard.categories.create ...etc
    //   because the prefix that defined in the group


    //PRODUCTS
    Route::resource('/products',ProductsController::class);

    //PROFILE USER
    Route::get('profile',[ProfileController::class,'edit'])->name('profile.edit');
    Route::patch('profile',[ProfileController::class,'update'])->name('profile.update'); //PUT مش ال  patch ليش استخدمت
    //patch في الراوت تبعها لذلك استخدمت ال  id  متعارف عليها انها بتاخد  put لانه ال
});
