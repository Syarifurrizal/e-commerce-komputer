@extends('layouts.app')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="container mt-4">
    <!-- Header Area: Judul, Search, dan Tombol -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <h4 class="fw-bold m-0">Rekomendasi Komputer & Hardware</h4>
        
        <div class="d-flex gap-2 align-items-center">
            <!-- Form Pencarian (Search Bar) -->
            <!-- Menggunakan url()->current() agar tetap di halaman ini saat mencari -->
            <form action="{{ url()->current() }}" method="GET" class="d-flex mb-0">
                <div class="input-group input-group-sm">
                    <input type="text" name="search" class="form-control" placeholder="Cari produk..." value="{{ request('search') }}">
                    <button class="btn btn-secondary" type="submit">
                        Cari
                    </button>
                </div>
            </form>

            <!-- Tombol Riwayat Transaksi -->
            <a href="{{ route('history') }}" class="btn btn-outline-secondary btn-sm text-nowrap">
                Riwayat Transaksi
            </a>
        </div>
    </div>

    <!-- Katalog Produk -->
    <div class="row g-4">
        @forelse($products as $product)
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card h-100 shadow-sm border-0 rounded-4">
                
                <!-- Area Gambar Produk -->
                <div class="p-3 bg-white text-center rounded-top-4">
                    <img src="{{ asset('img/' . $product->image) }}" 
                         onerror="this.src='https://dummyimage.com/300x250/f4f5f7/6c757d.jpg&text=No+Image'" 
                         class="img-fluid" 
                         alt="{{ $product->name }}" 
                         style="object-fit: contain; height: 180px;">
                </div>

                <!-- Info Produk -->
                <div class="card-body d-flex flex-column bg-light border-top">
                    <h6 class="card-title text-truncate mb-1" title="{{ $product->name }}">
                        {{ $product->name }}
                    </h6>
                    <small class="text-muted mb-2">Sisa Stok: {{ $product->stock }}</small>
                    
                    <h5 class="text-danger fw-bold mt-auto mb-3">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </h5>
                    
                    <!-- Tombol Beli -->
                    <form action="{{ route('checkout') }}" method="POST" class="w-100">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" class="btn btn-danger w-100 rounded-pill fw-bold shadow-sm">
                            Beli Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <!-- Tampilan jika tidak ada produk (termasuk jika hasil pencarian tidak ditemukan) -->
        <div class="col-12 text-center py-5">
            <h5 class="text-muted">Katalog masih kosong.</h5>
        </div>
        @endforelse
    </div>
</div>
@endsection