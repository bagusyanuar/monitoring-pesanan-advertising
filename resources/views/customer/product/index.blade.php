@extends('customer.layout')

@section('content')
    <div class="w-100 d-flex justify-content-between align-items-center mb-3">
        <p class="page-title">Product Kami</p>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0"  style="padding: 0 0;">
                <li class="breadcrumb-item"><a href="{{ route('customer.home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Product</li>
            </ol>
        </nav>
    </div>
    <div class="w-100">
        <div class="text-group-container mb-4">
            <i class='bx bx-search'></i>
            <input type="text" placeholder="cari product..." class="text-group-input" id="param"
                   name="param" aria-describedby="emailHelp">
        </div>
        <div id="panel-result" class="w-100">

        </div>
    </div>
{{--    <div class="d-flex">--}}
{{--        <div class="categories-sidebar">--}}
{{--            <a href="#" class="categories-link active" data-tag="all" id="cat-link-all">Semua</a>--}}
{{--            @foreach($categories as $category)--}}
{{--                <a href="#" class="categories-link" data-tag="{{ $category->id }}"--}}
{{--                   id="cat-link-{{ $category->id }}">{{ $category->nama }}</a>--}}
{{--            @endforeach--}}
{{--        </div>--}}
{{--        <div class="flex-grow-1" style="padding-left: 25px;">--}}


{{--        </div>--}}
{{--    </div>--}}
@endsection

@section('js')
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script>
        var path = '/{{ request()->path() }}';
        var selectedCategory = 'all';

        function eventChangeCategory() {
            $('.categories-link').on('click', function (e) {
                e.preventDefault();
                let tag = this.dataset.tag;
                selectedCategory = tag;
                $('.categories-link').removeClass('active');
                $('#cat-link-' + tag).addClass('active');
                getData();
            })
        }

        async function getData() {
            try {
                let resultEl = $('#panel-result');
                resultEl.empty();
                resultEl.append(createLoader('sedang mengunduh data...', 400));
                let param = $('#param').val();
                let url = path + '?param=' + param;
                let response = await $.get(url);
                let data = response['data'];
                resultEl.empty();
                if (data.length > 0) {
                    resultEl.append(createProductElement(data));
                    eventProductAction();
                } else {
                    resultEl.append(createEmptyProduct());
                }
            } catch (e) {
                alert('error' + e);
            }
        }

        function createProductElement(data = []) {
            let productsEl = '';
            $.each(data, function (k, v) {
                let id = v['id'];
                let image = v['gambar'];
                let name = v['nama'];
                let price = v['harga'];
                let isi = v['isi'];
                let hargaUkuran = v['harga_ukuran'] ? 'Harga berdasarkan ukuran' :'';
                let formattedPrice = price.toLocaleString('id-ID')
                productsEl += '<div class="card-product" data-id="' + id + '">' +
                    '<div class="image-container">' +
                    '<img src="' + image + '" alt="product-image" />' +
                    '</div>' +
                    '<div class="product-info w-100">' +
                    '<p class="product-name">' + name + '</p>' +
                    '<div>' +
                    ' <p style="margin-bottom: 0; font-size: 0.8em; font-weight: 600; color: var(--dark)">' +
                    'Isi : ' + isi +
                    '</p>' +
                    '<p style="margin-bottom: 0; font-size: 0.6em; font-weight: 500; color: var(--dark-tint)">' +
                    '' + hargaUkuran +
                    '</p>' +
                    '</div>' +
                    '<div class="d-flex justify-content-end align-items-center">' +
                    '<p class="product-price">Rp.' + formattedPrice + '</p>' +
                    '</div>' +
                    '</div>' +
                    '<div class="product-action">' +
                    '<a href="#" data-id="' + id + '" class="btn-shop">' +
                    '<i class="bx bx-cart-alt"></i>' +
                    '</a>' +
                    '</div>' +
                    '</div>';
            });
            return (
                '<div class="product-container" style="justify-content: start !important;">' + productsEl +
                '</div>'
            )
        }



        function eventProductAction() {
            $('.card-product').on('click', function () {
                let id = this.dataset.id;
                window.location.href = '/product/' + id;
            })

            $('.btn-cart').on('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                let id = this.dataset.id;
            })

            $('.btn-shop').on('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                let id = this.dataset.id;
            })
        }

        async function eventSearchHandler() {
            $("#param").keyup(
                debounce(function (e) {
                    console.log(e.currentTarget.value);
                    getData();
                }, 1000)
            );
        }

        $(document).ready(function () {
            // eventChangeCategory();
            getData();
            eventSearchHandler();
        });
    </script>
@endsection
