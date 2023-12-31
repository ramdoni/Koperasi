<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Home;
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

Route::get('/', Home::class)->name('home')->middleware('auth');
// Route::get('/', Home::class)->name('home');
Route::get('privacy', App\Http\Livewire\Privacy::class)->name('privacy');
Route::get('login', App\Http\Livewire\Login::class)->name('login');
Route::get('register', App\Http\Livewire\Register::class)->name('register');
Route::get('konfirmasi-pembayaran',App\Http\Livewire\KonfirmasiPembayaran::class)->name('konfirmasi-pembayaran');
Route::get('konfirmasi-pendaftaran',App\Http\Livewire\KonfirmasiPendaftaran::class)->name('konfirmasi-pendaftaran');
Route::get('transaksi/cetak-struk-kasir/{data}',[\App\Http\Controllers\TransaksiController::class,'cetakStruk'])->name('transaksi.cetak-struk-kasir');

// Route::get('print-price-tag/{data}',[App\Http\Controllers\PriceTagController::class,'tmgMonthly'])->name('print-price-tag');


// All login
Route::group(['middleware' => ['auth']], function(){    
    Route::get('profile',App\Http\Livewire\Profile::class)->name('profile');
    Route::get('back-to-admin',[App\Http\Controllers\IndexController::class,'backtoadmin'])->name('back-to-admin');
});
Route::get('user-member/print-member/{id}',[\App\Http\Controllers\UserMemberController::class,'printMember'])->name('user-member.print-member');
Route::get('user-member/print-iuran/{id}/{tahun}',[\App\Http\Controllers\UserMemberController::class,'printIuran'])->name('user-member.print-iuran');
Route::post('ajax/get-member', [\App\Http\Controllers\AjaxController::class,'getMember'])->name('ajax.get-member');   
Route::get('set-navbar-show',function(){
    $navbar = get_setting('show-navbar');
    if($navbar==0 || $navbar==""){
        update_setting('show-navbar',1);
    }else{
        update_setting('show-navbar',0);
    }
})->name('set-navbar-show');

// Administrator
Route::group(['middleware' => ['auth','access:1']], function(){ 
    Route::get('qrcode',[\App\Http\Controllers\UserMemberController::class,'qrcode'])->name('qrcode');
    Route::get('log-activity',App\Http\Livewire\LogActivity\Index::class)->name('log-activity.index');
    Route::get('setting',App\Http\Livewire\Setting::class)->name('setting');
    Route::get('users/insert',App\Http\Livewire\User\Insert::class)->name('users.insert');
    Route::get('user-access', App\Http\Livewire\UserAccess\Index::class)->name('user-access.index');
    Route::get('user-access/insert', App\Http\Livewire\UserAccess\Insert::class)->name('user-access.insert');
    Route::get('users',App\Http\Livewire\User\Index::class)->name('users.index');
    Route::get('users/edit/{id}',App\Http\Livewire\User\Edit::class)->name('users.edit');
    Route::post('users/autologin/{id}',[App\Http\Livewire\User\Index::class,'autologin'])->name('users.autologin');
    Route::get('module',App\Http\Livewire\Module\Index::class)->name('module.index');
    Route::get('module/insert',App\Http\Livewire\Module\Insert::class)->name('module.insert');
    Route::get('module/edit/{id}',App\Http\Livewire\Module\Edit::class)->name('module.edit');

    /**
     * E-Catalog
     */
    Route::get('ecatalog', App\Http\Livewire\Ecatalog\Index::class)->name('ecatalog.index');
    
    /**
     * Keanggotaan
     */
    Route::get('user-member', App\Http\Livewire\UserMember\Index::class)->name('user-member.index');
    Route::get('user-member/insert', App\Http\Livewire\UserMember\Insert::class)->name('user-member.insert');
    Route::get('user-member/edit/{id}',App\Http\Livewire\UserMember\Edit::class)->name('user-member.edit');
    Route::get('user-member/approval/{id}',App\Http\Livewire\UserMember\Approval::class)->name('user-member.approval');
    Route::get('user-member/proses/{id}',App\Http\Livewire\UserMember\Proses::class)->name('user-member.proses');
    Route::get('user-member/klaim/{id}',App\Http\Livewire\UserMember\Klaim::class)->name('user-member.klaim');
    Route::get('user-simpanan',App\Http\Livewire\UserSimpanan\Index::class)->name('user-simpanan.index');
    
    Route::get('bank-account',App\Http\Livewire\BankAccount\Index::class)->name('bank-account.index');
    Route::get('bank-account/insert',App\Http\Livewire\BankAccount\Insert::class)->name('bank-account.insert');
    Route::get('bank-account/edit/{id}',App\Http\Livewire\BankAccount\Edit::class)->name('bank-account.edit');
    Route::get('migration',App\Http\Livewire\Migration\Index::class)->name('migration.index');

    Route::get('simpanan',App\Http\Livewire\Simpanan\Index::class)->name('simpanan.index');

    Route::get('shu',App\Http\Livewire\Shu\Index::class)->name('shu.index');
    Route::get('jenis-simpanan',App\Http\Livewire\JenisSimpanan\Index::class)->name('jenis-simpanan.index');
    Route::get('jenis-pinjaman',App\Http\Livewire\JenisPinjaman\Index::class)->name('jenis-pinjaman.index');
    Route::get('transaksi',App\Http\Livewire\Transaksi\Index::class)->name('transaksi.index');
    Route::get('transaksi/items/{data}',App\Http\Livewire\Transaksi\Items::class)->name('transaksi.items');
    Route::get('transaksi/cetak-barcode/{no}',[\App\Http\Controllers\TransaksiController::class,'cetakBarcode'])->name('transaksi.cetak-barcode');
    Route::get('transaksi/cetak-struk/{data}',[\App\Http\Controllers\TransaksiController::class,'cetakStruk'])->name('transaksi.cetak-struk');

    // Produk
    Route::get('vendor/index',App\Http\Livewire\Vendor\Index::class)->name('vendor.index');
    Route::get('purchase-request/index',App\Http\Livewire\PurchaseRequest\Index::class)->name('purchase-request.index');
    Route::get('purchase-order/index',App\Http\Livewire\PurchaseOrder\Index::class)->name('purchase-order.index');
    Route::get('purchase-order/insert',App\Http\Livewire\PurchaseOrder\Insert::class)->name('purchase-order.insert');
    Route::get('purchase-order/detail/{data}',App\Http\Livewire\PurchaseOrder\Detail::class)->name('purchase-order.detail');
    Route::get('purchase-order/insert-delivery-order/{data}',App\Http\Livewire\PurchaseOrder\InsertDeliveryOrder::class)->name('purchase-order.insert-delivery-order');
    
    Route::get('transaksi/cetak-struk-admin/{data}',[\App\Http\Controllers\TransaksiController::class,'cetakStruk'])->name('transaksi.cetak-struk-admin');

    Route::get('invoice-transaksi/detail/{data}',App\Http\Livewire\InvoiceTransaksi\Detail::class)->name('invoice-transaksi.detail');
    Route::get('invoice-transaksi/index',App\Http\Livewire\InvoiceTransaksi\Index::class)->name('invoice-transaksi.index');

    Route::get('user-supplier', App\Http\Livewire\UserSupplier\Index::class)->name('user-supplier.index');
    Route::get('user-supplier/insert', App\Http\Livewire\UserSupplier\Insert::class)->name('user-supplier.insert');
    Route::get('user-supplier/listproduk/{data}',App\Http\Livewire\UserSupplier\ListProduk::class)->name('user-supplier.listproduk');
    Route::get('voucher',App\Http\Livewire\Voucher\Index::class)->name('voucher.index');
});

# Administrator dan Kasir
Route::group(['middleware' => ['auth','access:1,6']], function(){
    Route::get('product/index',App\Http\Livewire\Product\Index::class)->name('product.index');
    Route::get('product/insert',App\Http\Livewire\Product\Insert::class)->name('product.insert');
    Route::get('product/detail/{data}',App\Http\Livewire\Product\Detail::class)->name('product.detail');
    Route::get('konsinyasi/index',App\Http\Livewire\Konsinyasi\Index::class)->name('konsinyasi.index');
    Route::get('konsinyasi/insert',App\Http\Livewire\Konsinyasi\Insert::class)->name('konsinyasi.insert');
    Route::get('konsinyasi/detail/{data}',App\Http\Livewire\Konsinyasi\Detail::class)->name('konsinyasi.detail');
});

# Kasir
Route::group(['middleware' => ['auth','access:6']], function(){
    Route::get('kasir/index',App\Http\Livewire\Kasir\Index::class)->name('kasir.index');
    Route::get('transaksi/cetak-struk/{data}',[\App\Http\Controllers\TransaksiController::class,'cetakStruk'])->name('transaksi.cetak-struk');
});

# Ketua Koperasi and Administrator
Route::group(['middleware' => ['auth','access:1,3']], function(){
    Route::get('pinjaman',App\Http\Livewire\Pinjaman\Index::class)->name('pinjaman.index');
    Route::get('pinjaman/insert',App\Http\Livewire\Pinjaman\Insert::class)->name('pinjaman.insert');
    Route::get('pinjaman/edit/{data}',App\Http\Livewire\Pinjaman\Edit::class)->name('pinjaman.edit');
});

// Supplier
// Route::group(['middleware' => ['auth','access:7']], function(){
//     // Route::get('/', App\Http\Livewire\ProductSupplier\Index::class)->name('product-supplier.index');
//     Route::get('product-supplier',App\Http\Livewire\ProductSupplier\Index::class)->name('product-supplier.index');
//     Route::get('product-supplier/insert',App\Http\Livewire\ProductSupplier\Insert::class)->name('product-supplier.insert');
//     Route::get('product-supplier/detail/{data}',App\Http\Livewire\ProductSupplier\Detail::class)->name('product-supplier.detail');

//     Route::get('purchase-order-supplier',App\Http\Livewire\PurchaseOrderSupplier\Index::class)->name('purchase-order-supplier.index');
//     // Route::get('purchase-order-supplier/insert',App\Http\Livewire\PurchaseOrderSupplier\Insert::class)->name('purchase-order-supplier.insert');
//     Route::get('purchase-order-supplier/detail/{data}',App\Http\Livewire\PurchaseOrderSupplier\Detail::class)->name('purchase-order-supplier.detail');
//     Route::get('purchase-order-supplier/insert-delivery-order/{data}',App\Http\Livewire\PurchaseOrderSupplier\InsertDeliveryOrder::class)->name('purchase-order-supplier.insert-delivery-order');
//     // Route::get('invoice-supplier/index',App\Http\Livewire\PurchaseOrderSupplier\Index::class)->name('invoice-supplier.index');
// });
 