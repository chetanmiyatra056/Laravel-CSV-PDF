<?php

use App\Http\Controllers\CSVDownloadController;
use App\Http\Controllers\Frontend\DropDownController;
use App\Http\Controllers\Frontend\EditController;
use App\Http\Controllers\Frontend\EditPasswordController;
use App\Http\Controllers\Frontend\ListController;
use App\Http\Controllers\Frontend\SellerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\RegisterController;
use App\Http\Controllers\Frontend\LoginController;
use App\Http\Controllers\Frontend\LogoutController;
use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\Frontend\SellerlogoutController;
use App\Http\Controllers\Frontend\UserlogoutController;
use App\Http\Controllers\Frontend\WelcomeController;


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

// Route::get('/', function () {
//     return view('welcome');
// });


Route::post('api/fetch-state', [DropDownController::class, 'fatchState']);
Route::post('api/fetch-cities', [DropDownController::class, 'fatchCity']);

Route::get("/", [HomeController::class, "index"]);

Route::get("/list", [ListController::class, "list"])->name("list");

Route::get("/pdf", [ListController::class, "pdf"])->name("pdf");

Route::get('/export-csv', [CSVDownloadController::class, 'exportCSV'])->name('export');
Route::get('/export-pdf', [CSVDownloadController::class, 'downloadPDF'])->name('downloadPDF');

Route::group(['middleware' => 'notlogin'], function () {
    
    
    Route::get("/register", [RegisterController::class, "register"])->name("register");
    Route::post("/register", [RegisterController::class, "postregister"])->name("postregister");
    
    Route::get("/login", [LoginController::class, "login"])->name("login");
    Route::post("/login", [LoginController::class, "postlogin"])->name("postlogin");
});



Route::group(['middleware' => 'login'], function () {

    Route::group(['middleware' => 'seller'], function () {
        Route::get("/sellerdash", [SellerlogoutController::class, "sellerlogout"])->name("sellerlogout");
        
        Route::get("/seller", [SellerController::class, "seller"])->name("seller");
    });
    
    Route::group(['middleware' => 'users'], function () {
        Route::get("/usersdash", [UserlogoutController::class, "userlogout"])->name("userlogout");
        
        Route::get("/welcome", [WelcomeController::class, "welcome"])->name("welcome");
    });
    
    Route::get("/profile", [ProfileController::class, "profile"])->name("profile");
    Route::post("/edit/{id}", [EditController::class, "edit"])->name("edit");
    
    Route::delete('/record/{id}', [ProfileController::class, 'destroy'])->name('record.destroy');

    Route::get("/password", [EditPasswordController::class, "password"])->name("password");
    Route::post("/upassword", [EditPasswordController::class, "upassword"])->name("upassword");

    Route::post("/logout", [LogoutController::class, "logout"])->name("logout");

});


