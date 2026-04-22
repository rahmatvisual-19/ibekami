<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PartnershipController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\MachineController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\WhatsAppWebhookController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', [Controller::class, 'home'])->name('home');

// Ganti bahasa manual
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['id', 'en'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');
Route::get('/catalogue', [Controller::class, 'shop'])->name('shop');
Route::get('/product/{product_id}', [Controller::class, 'product'])->name('product');
Route::get('/machine', [Controller::class, 'machine'])->name('machine');
Route::get('/privacy-policy', [Controller::class, 'privacyPolicy'])->name('privacy.policy');
Route::post('/product/click', [ProductController::class, 'orderClickIncrement'])->name('product.order.click');
use Illuminate\Support\Facades\Redirect;

Route::get('/wadmin', function () {
    return Redirect::away('https://wa.me/628170769999?text=Halo%20Admin,%20saya%20tertarik%20dengan%20produk%20dari%20Ibekami.id.%20Bisa%20bantu%20untuk%20info%20lebih%20lanjut?');
}); 

Route::match(['get', 'post'], '/whatsapp/webhook', [WhatsAppWebhookController::class, 'handle']);

// URL login 
Route::get('/login-ibeka99', [AuthController::class, 'index'])->name('login');
Route::post('/login-ibeka99', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// dashboard
Route::prefix('dashboard')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

    // User Routes
    Route::prefix('Daftar-User')->group(function () {
        Route::get('/', [UserController::class, 'daftaruser'])->name('user.index');
        Route::get('/Tambah-Form', [UserController::class, 'index']);
        Route::post('/Tambah', [UserController::class, 'create'])->name('user.add');
        Route::get('/edit-user/{username}', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/{username}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/hapus-user/{username}', [UserController::class, 'delete'])->name('user.destroy');
    });

    // Product Type Routes
    Route::prefix('jenis-produk')->group(function () {
        Route::get('/', [JenisController::class, 'daftarjenis'])->name('jenis.index');
        Route::get('/add', function() {
            return view('backend.pages.addjenis');
        });
        Route::post('/add', [JenisController::class, 'create']);
        Route::get('/edit-jenis/{id}', [JenisController::class, 'edit'])->name('jenis.edit');
        Route::put('/{id}', [JenisController::class, 'update'])->name('jenis.update');
        Route::delete('/hapus-jenis/{id}', [JenisController::class, 'delete'])->name('jenis.destroy');
    });
    
    // Category Routes
    Route::prefix('kategori-product')->group(function () {
        Route::get('/', [KategoriController::class, 'daftarkategori'])->name('kategori.index');
        Route::get('/isi-kategori', [KategoriController::class, 'index']);
        Route::post('/isi-kategori', [KategoriController::class, 'create']);
        Route::get('/edit-kategori/{id}', [KategoriController::class, 'edit'])->name('kategori.edit');
        Route::put('/{id}', [KategoriController::class, 'update'])->name('kategori.update');
        Route::delete('/hapus-kategori/{id}', [KategoriController::class, 'delete'])->name('kategori.destroy');
    });

    // Product Routes
    Route::prefix('daftar-product')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('product.index');
        Route::get('/tambah-product', [ProductController::class, 'create'])->name('product.add');
        Route::post('/product-tambah', [ProductController::class, 'store'])->name('product.tambah');

        Route::delete('/hapus-produk/{id}', [ProductController::class, 'delete'])->name('produk.destroy');
        Route::get('/editproduk/{id}', [ProductController::class,'edit'])->name('product.edit');
        Route::put('/editproduk/{id}', [ProductController::class, 'update'])->name('product.update');
    });


    // Partnership
    Route::prefix('partnership')->group(function () {
        Route::get('/', [PartnershipController::class, 'indexPartner'])->name('partner');
        Route::get('/addPartner', function () {
            return view('backend.pages.addpartner');
        });
        Route::post('/addPartner', [PartnershipController::class, 'store'])->name('partner.add');
        Route::get('/edit-partner/{id}', [PartnershipController::class, 'edit'])->name('partner.edit');
        Route::put('/{id}', [PartnershipController::class, 'update'])->name('partner.update');
        Route::delete('/hapus-partner/{id}', [PartnershipController::class, 'delete'])->name('partner.destroy');
    });

    // Review Routes
    Route::prefix('review')->group(function(){
        Route::get('/',[ReviewController::class, 'index']) -> name('review');
        Route::get('/addReview', function(){ return view('backend.pages.addreview');});
        Route::post('/addReview', [ReviewController::class, 'create']) -> name('review.add');
        Route::get('/editreview/{id}', [ReviewController::class, 'edit']) -> name('review.edit');
        Route::put('/{id}', [ReviewController::class, 'update']) ->name ('review.update');
        Route::delete('/hapus-review/{id}', [ReviewController::class, 'delete']) -> name('review.destroy');
    });
    
    // Banner Routes
    Route::prefix('banner')->group(function(){
        Route::get('/', [BannerController::class, 'index']) -> name('banner.index');
        Route::get('/addbanner', function(){return view('backend.pages.addbanner');});
        Route::post('/addbanner', [BannerController::class, 'create']) -> name('banner.add');
        Route::get('/editbanner/{id}', [BannerController::class, 'edit']) -> name('banner.edit');
        Route::put('/{id}', [BannerController::class, 'update']) -> name('banner.update');
        Route::delete('/hapusBanner/{id}', [BannerController::class, 'delete']) -> name('banner.destroy');
    });
    Route::prefix('machine')->group(function(){
        Route::get('/', [MachineController::class, 'index']) -> name('machine.index');
        Route::get('/addmachine', function(){return view('backend.pages.addmachine');});
        Route::post('/addmachine', [MachineController::class, 'create']) -> name('machine.add');
        Route::delete('/hapusMachine/{id}', [MachineController::class, 'delete']) -> name('machine.destroy');
        Route::get('/editmachine/{id}', [MachineController::class, 'edit']) -> name('machine.edit');
        Route::put('/{id}', [MachineController::class, 'update']) -> name('machine.update');
       
    });
});