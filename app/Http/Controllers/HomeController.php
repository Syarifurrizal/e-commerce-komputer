<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        // 1. Ambil inputan dari kotak pencarian (jika ada)
        $search = $request->input('search');

        // 2. Query produk berdasarkan pencarian & jumlah terbeli
        $products = Product::when($search, function ($query, $search) {
                // Jika user mengetik pencarian, cari di kolom 'name'
                return $query->where('name', 'like', "%{$search}%");
            })
            // Hitung jumlah relasi produk ini di tabel order_details
            ->withCount('orderDetails') 
            // Urutkan berdasarkan yang paling banyak dibeli ke paling sedikit
            ->orderBy('order_details_count', 'desc')
            // Jika jumlah belinya sama, urutkan dari produk terbaru (opsional)
            ->orderBy('created_at', 'desc') 
            ->get();

        // 3. Jika yang login adalah ADMIN, lempar ke tampilan admin
        if (Auth::user()->role === 'admin') {
            return view('admin.dashboard', compact('products'));
        }

        // 4. Jika yang login adalah PEMBELI, lempar ke halaman home biasa
        return view('home', compact('products'));

        
    }
    public function history()
    {
        // Ambil pesanan milik user yang sedang login, urutkan dari yang terbaru
        $orders = \App\Models\Order::where('user_id', Auth::id())
                    ->with('orderDetails.product') // Eager load untuk mengambil detail & data produk
                    ->latest()
                    ->get();

        return view('history', compact('orders'));
    }
    
}