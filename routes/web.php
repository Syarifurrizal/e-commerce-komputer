<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request; // Penting untuk menangkap request pencarian
use App\Http\Controllers\OrderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;

// Halaman Katalog Utama (Dilengkapi Pencarian & Produk Terlaris)
Route::get('/', function (Request $request) {
    // Tangkap kata kunci pencarian
    $search = $request->input('search');

    // Cari produk berdasarkan nama, lalu urutkan dari yang paling sering dibeli
    $products = Product::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%");
        })
        ->withCount('orderDetails') // Menghitung produk dari tabel pesanan
        ->orderBy('order_details_count', 'desc') // Mengurutkan dari paling laku
        ->orderBy('created_at', 'desc') // Jika jumlah beli sama, urutkan dari yang terbaru
        ->get();

    return view('home', compact('products')); 
});
// Route Riwayat Transaksi Pembeli
Route::get('/riwayat-transaksi', [HomeController::class, 'history'])->name('history');

// Route bawaan Laravel UI Auth (Login, Register, dll)
Auth::routes();

// Halaman Dashboard (Akan memisahkan admin & pembeli berdasarkan logika di HomeController)
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Route Checkout Pembeli (Wajib login diatur di controller atau bisa tambah middleware di sini)
Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout')->middleware('auth');

// Route CRUD Produk khusus Admin (kecuali index karena sudah pakai /home)
Route::resource('products', ProductController::class)->except(['index', 'show']);

//payment
Route::get('/payment/{id}', [App\Http\Controllers\OrderController::class, 'payment'])->name('payment');