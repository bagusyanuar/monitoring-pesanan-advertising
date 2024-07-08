@extends('customer.layout')

@section('content')
    @if (\Illuminate\Support\Facades\Session::has('failed'))
        <script>
            Swal.fire("Ooops", '{{ \Illuminate\Support\Facades\Session::get('failed') }}', "error")
        </script>
    @endif
    @if (\Illuminate\Support\Facades\Session::has('success'))
        <script>
            Swal.fire({
                title: 'Success',
                text: '{{ \Illuminate\Support\Facades\Session::get('success') }}',
                icon: 'success',
                timer: 700
            }).then(() => {
                window.location.reload();
            })
        </script>
    @endif
    <div class="w-100 d-flex justify-content-between align-items-center mb-3">
        <p class="page-title">Pesanan</p>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('customer.home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('customer.order') }}">Pesanan</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $data->no_penjualan }}</li>
            </ol>
        </nav>
    </div>
    <div class="w-100">
        <div class="mb-3" style="font-size: 0.8em; color: var(--dark);">
            <div class="d-flex align-items-center mb-1">
                <span style="" class="me-2">No. Pembelian :</span>
                <span style="font-weight: 600;">{{ $data->no_penjualan }}</span>
            </div>
            <div class="d-flex align-items-center mb-1">
                <span style="" class="me-2">Tgl. Pembelian :</span>
                <span style="font-weight: 600;">{{ \Carbon\Carbon::parse($data->tanggal)->format('d F Y') }}</span>
            </div>
            <div class="d-flex align-items-center mb-1">
                <span style="" class="me-2">Status :</span>
                <span style="font-weight: 600;">
                    @if($data->status === 0)
                        <div class="chip-status-warning">menunggu pembayaran</div>
                    @elseif($data->status === 1)
                        <div class="chip-status-warning">menunggu konfirmasi pembayaran</div>
                    @elseif($data->status === 2)
                        <div class="chip-status-warning">pesanan di proses</div>
                    @elseif($data->status === 3)
                        <div class="chip-status-info">pesanan siap di ambil</div>
                    @elseif($data->status === 4)
                        <div class="chip-status-success">selesai</div>
                    @elseif($data->status === 5)
                        <div class="chip-status-danger">Pesanan Di tolak</div>
                    @endif
                </span>
            </div>

            @if($data->status === 5)
                <div class="d-flex align-items-center mb-1">
                    <span style="" class="me-2">Alasan Penolakan :</span>
                    <span style="font-weight: 600;">{{ $data->pembayaran_status->deskripsi }}</span>
                </div>
            @endif
        </div>
    </div>
    <hr class="custom-divider"/>
    <div class="d-flex" style="gap: 1rem">

        <div class="cart-list-container">
            @forelse($data->keranjang as $key => $cart)
                <div class="cart-item-container mb-3">
                    <img src="{{ $cart->product->gambar }}" alt="product-image">
                    <div class="flex-grow-1">
                        <p style="color: var(--dark); font-size: 1em; margin-bottom: 0; font-weight: bold">{{ $cart->product->nama }}</p>
                        <div class="d-flex align-items-center" style="font-size: 0.8em;">
                            <span style="color: var(--dark-tint);" class="me-1">Jumlah: </span>
                            <span style="color: var(--dark); font-weight: bold;">{{ $cart->qty }}X
                                    @if($cart->product->harga_ukuran)
                                    <span style="font-weight: 500; color: var(--dark-tint);" class="ms-1">
                                            {{ ($cart->panjang * $cart->lebar) }}meter
                                        </span>
                                    @endif
                                (Rp.{{ number_format($cart->harga, 0, ',' ,'.') }})</span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end" style="width: 150px;">
                        <p style="font-size: 1em; font-weight: bold; color: var(--dark);">
                            Rp{{ number_format($cart->total, 0, ',' ,'.') }}</p>
                    </div>
                </div>
            @empty
                <div class="w-100 d-flex justify-content-center align-items-center flex-column"
                     style="background-color: white; border-radius: 12px; box-shadow: 0 8px 10px rgba(0, 0, 0, 0.2); padding: 1rem 1.5rem; min-height: 495px; ">
                    <p style="margin-bottom: 1rem; font-weight: bold;">Belum Ada Data Belanja...</p>
                    <a href="{{ route('customer.product') }}" class="btn-action-accent" style="width: fit-content">Pergi
                        Belanja</a>
                </div>
            @endforelse
        </div>
        <div class="cart-action-container">
            <p style="font-size: 1em; font-weight: bold; color: var(--dark);">Ringkasan Belanja</p>
            <hr class="custom-divider"/>
            <div class="d-flex align-items-center justify-content-between mb-1" style="font-size: 1em;">
                <span style="color: var(--dark-tint); font-size: 0.8em">Total</span>
                <span id="lbl-sub-total"
                      style="color: var(--dark); font-weight: 600;">Rp{{ number_format($data->total, 0, ',', '.') }}</span>
            </div>
            @if($data->status === 0 || $data->status === 5)
                <hr class="custom-divider"/>
                <a href="{{ route('customer.order.payment', ['id' => $data->id]) }}" class="btn-action-accent mb-1"
                   id="btn-checkout">Bayar</a>
            @endif
        </div>
    </div>
@endsection
