@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Riwayat Transaksi Saya</h4>
        <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali ke Katalog
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-4 py-3">Tanggal Transaksi</th>
                        <th>Nama Produk</th>
                        <th class="text-center">Jumlah Beli</th>
                        <th class="text-end px-4">Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        @foreach($order->orderDetails as $detail)
                        <tr>
                            <td class="px-4 text-muted">{{ $order->created_at->format('d M Y, H:i') }}</td>
                            <td class="fw-medium">{{ $detail->product->name ?? 'Produk sudah dihapus admin' }}</td>
                            <td class="text-center">{{ $detail->quantity }}</td>
                            <td class="text-end px-4 fw-bold text-success">
                                Rp {{ number_format($detail->product->price * $detail->quantity, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">Belum ada riwayat transaksi. Ayo mulai belanja!</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection