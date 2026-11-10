@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h5 class="mb-0">Halaman Pembayaran</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info text-center">
                        Selesaikan pembayaran Anda untuk memproses pesanan.
                    </div>
                    
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Produk</strong></td>
                            <td>: {{ $product->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Harga</strong></td>
                            <td>: Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Metode Bayar</strong></td>
                            <td>
                                <select class="form-select">
                                    <option>Transfer Bank (BCA)</option>
                                    <option>E-Wallet (GoPay)</option>
                                    <option>QRIS</option>
                                </select>
                            </td>
                        </tr>
                    </table>

                    <hr>
                    <h4 class="text-center text-success mb-4">Total: Rp {{ number_format($product->price, 0, ',', '.') }}</h4>

                    <!-- Form ini akan mengarah ke rute checkout aslimu -->
                    <form action="{{ url('/checkout') }}" method="POST">
                        @csrf
                        <!-- Input hidden ini membawa ID produk ke fungsi checkout -->
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        
                        <button type="submit" class="btn btn-primary w-100 btn-lg">
                            Konfirmasi Pembayaran
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection