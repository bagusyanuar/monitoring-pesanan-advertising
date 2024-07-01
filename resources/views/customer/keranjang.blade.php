@extends('customer.layout')

@section('content')
    <div class="main-content">
        <div class="w-100 d-flex justify-content-between align-items-center mb-3">
            <p class="page-title">Cart</p>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="padding: 0 0;">
                    <li class="breadcrumb-item"><a href="{{ route('customer.home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Cart</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex" style="gap: 1rem">
            <div class="cart-list-container">
                @forelse($carts as $cart)
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
                            <div class="d-flex justify-content-start w-100">
                                <a href="#" class="btn-delete-item" data-id="{{ $cart->id }}">
                                    <i class='bx bx-trash'></i>
                                </a>
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
                    <span style="color: var(--dark-tint); font-size: 0.8em">Subtotal</span>
                    <span id="lbl-sub-total"
                          style="color: var(--dark); font-weight: 600;">Rp{{ number_format($subTotal, 0, ',', '.') }}</span>
                </div>
                <hr class="custom-divider"/>
                <a href="#" class="btn-action-accent mb-1" id="btn-checkout">Checkout</a>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script>
        var path = '/{{request()->path()}}';


        function eventDeleteCart() {
            $('.btn-delete-item').on('click', function (e) {
                e.preventDefault();
                let id = this.dataset.id;
                AlertConfirm('Konfirmasi', 'Apakah anda yakin ingin menghapus data?', function () {
                    let url = path + '/' + id + '/delete';
                    BaseDeleteHandler(url, id);
                })
            })
        }


        function eventCheckout() {
            $('#btn-checkout').on('click', function (e) {
                e.preventDefault();
                let id = this.dataset.id;
                checkoutHandler(id)
            })
        }

        async function checkoutHandler(id) {
            try {
                let url = path + '/checkout';
                blockLoading(true);
                let response = await $.post(url);
                let transID = response['data'];
                blockLoading(false);
                Swal.fire({
                    title: 'Success',
                    text: 'Berhasil melakukan checkout...',
                    icon: 'success',
                    timer: 700
                }).then(() => {
                    window.location.href = '/pesanan/' + transID + '/pembayaran';
                })
            } catch (e) {
                blockLoading(false);
                let error_message = JSON.parse(e.responseText);
                ErrorAlert('Error', error_message.message);
            }
        }

        $(document).ready(function () {
            eventDeleteCart();
            eventCheckout();
        })
    </script>
@endsection

