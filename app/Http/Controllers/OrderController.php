<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Pastikan hanya user yang sudah login yang bisa beli
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function checkout(Request $request)
    {
        // 1. Validasi produk yang diklik
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $product = Product::findOrFail($request->product_id);

        // 2. Cek apakah stok masih ada
        if ($product->stock < 1) {
            return redirect()->back()->with('error', 'Maaf, stok ' . $product->name . ' habis!');
        }

        // 3. Simpan data ke tabel 'orders'
        $order = Order::create([
            'user_id' => Auth::id(),
            'order_date' => now(),
            'total_price' => $product->price,
        ]);

        // 4. Simpan detail barang ke tabel 'order_details'
        OrderDetail::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'subtotal' => $product->price,
        ]);

        // 5. Kurangi stok produk di tabel 'products'
        $product->decrement('stock', 1);

        // 6. Kembalikan ke halaman home dengan pesan sukses
        return redirect()->back()->with('success', 'Berhasil membeli ' . $product->name . '!');
    }
}