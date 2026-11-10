<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function __construct()
    {
        // Memastikan hanya user yang login yang bisa akses
        $this->middleware('auth');
    }

    // Menampilkan Form Tambah Produk
    public function create()
    {
        $categories = Category::all();
        return view('admin.create', compact('categories'));
    }

    // Menyimpan Produk Baru ke Database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        // Proses Upload Gambar ke folder public/img (menyesuaikan kode lama Anda)
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('img'), $imageName);
            $data['image'] = $imageName;
        }

        Product::create($data);

        return redirect()->route('home')->with('success', 'Produk berhasil ditambahkan!');
    }

    // Menampilkan Form Edit Produk
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.edit', compact('product', 'categories'));
    }

    // Mengupdate Produk di Database
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        // Proses Ganti Gambar
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($product->image && File::exists(public_path('img/' . $product->image))) {
                File::delete(public_path('img/' . $product->image));
            }
            // Upload gambar baru
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('img'), $imageName);
            $data['image'] = $imageName;
        }

        $product->update($data);

        return redirect()->route('home')->with('success', 'Produk berhasil diupdate!');
    }

    // Menghapus Produk dari Database
    public function destroy(Product $product)
    {
        // Hapus gambar dari folder jika ada
        if ($product->image && File::exists(public_path('img/' . $product->image))) {
            File::delete(public_path('img/' . $product->image));
        }

        $product->delete();

        return redirect()->route('home')->with('success', 'Produk berhasil dihapus!');
    }
}