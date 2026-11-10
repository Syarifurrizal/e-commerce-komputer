@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <!-- Pesan Sukses / Error -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Gudang Admin - Manajemen Produk</h4>
        <!-- Tombol Terhubung ke Halaman Create -->
        <a href="{{ route('products.create') }}" class="btn btn-primary shadow-sm">
            + Tambah Produk Baru
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="px-4 py-3">Nama Produk</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th class="text-center">Aksi (Khusus Admin)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td class="px-4 fw-medium">{{ $product->name }}</td>
                        <td class="text-danger fw-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td>{{ $product->stock }} Pcs</td>
                        <td class="text-center">
                            <!-- Tombol Edit -->
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-warning me-1">Edit</a>
                            
                            <!-- Tombol Hapus (Harus pakai form) -->
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">Belum ada produk di database.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection