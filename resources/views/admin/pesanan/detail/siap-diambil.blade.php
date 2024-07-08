@extends('admin.layout')

@section('content')
    <div class="lazy-backdrop" id="overlay-loading">
        <div class="d-flex flex-column justify-content-center align-items-center">
            <div class="spinner-border text-light" role="status">
            </div>
            <p class="text-light">Sedang Menyimpan Data...</p>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-1">
        <div>
            <p class="content-title">Pesanan Siap Diambil</p>
            <p class="content-sub-title">Manajemen data pesanan siap diambil</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.order') }}">Pesanan</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $data->no_penjualan }}</li>
            </ol>
        </nav>
    </div>
    <div class="card-content">
        <div class="content-header mb-3">
            <p class="header-title" style="font-size: 0.8em">Data Pesanan</p>
        </div>
        <hr class="custom-divider"/>
        <div class="row w-100">
            <div class="col-8">
                <div class="w-100 d-flex align-items-center mb-1"
                     style="font-size: 0.8em; font-weight: 600; color: var(--dark);">
                    <p style="margin-bottom: 0; font-weight: 500;" class="me-2">No. Pesanan :</p>
                    <p style="margin-bottom: 0">{{ $data->no_penjualan }}</p>
                </div>
                <div class="w-100 d-flex align-items-center mb-1"
                     style="font-size: 0.8em; font-weight: 600; color: var(--dark);">
                    <p style="margin-bottom: 0; font-weight: 500;" class="me-2">Tanggal Pesanan :</p>
                    <p style="margin-bottom: 0">{{ \Carbon\Carbon::parse($data->tanggal)->format('d F Y') }}</p>
                </div>
                <div class="w-100 d-flex align-items-center mb-1"
                     style="font-size: 0.8em; font-weight: 600; color: var(--dark);">
                    <p style="margin-bottom: 0; font-weight: 500;" class="me-2">Customer :</p>
                    <p style="margin-bottom: 0">{{ $data->user->customer->nama }}</p>
                </div>
                <div class="w-100 d-flex align-items-center mb-1"
                     style="font-size: 0.8em; font-weight: 600; color: var(--dark);">
                    <p style="margin-bottom: 0; font-weight: 500;" class="me-2">No. HP :</p>
                    <div style="margin-bottom: 0" class="d-flex align-items-center">
                        <span>{{ $data->user->customer->no_hp }}</span>
                        <a href="https://wa.me/{{$data->user->customer->no_hp}}" class="ms-1" target="_blank"
                           style="text-decoration: none; color: forestgreen; font-size: 1em;">
                            <i class="bx bxl-whatsapp"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-4"></div>
        </div>
        <hr class="custom-divider"/>
        <table id="table-data-cart" class="display table w-100">
            <thead>
            <tr>
                <th width="5%" class="text-center">#</th>
                <th width="12%" class="text-center middle-header">Gambar</th>
                <th>Nama Product</th>
                <th width="10%" class="text-center">Qty</th>
                <th width="10%" class="text-end">Harga</th>
                <th width="10%" class="text-end">Total</th>
            </tr>
            </thead>
        </table>
        <hr class="custom-divider"/>
        <div class="w-100 d-flex justify-content-end" style="font-size: 0.8em; font-weight: bold; color: var(--dark);">
            <div class="me-2 w-100 text-end" style="width: 80%">Total :</div>
            <div class="text-end" style="width: 20%">Rp.{{ number_format($data->total, 0, ',', '.') }}</div>
        </div>


        <hr class="custom-divider"/>
        <p style="font-size: 0.8em; font-weight: 600; color: var(--dark);">Konfirmasi Status Proses</p>
        <div class="w-100">
            <label for="status" class="form-label input-label">Status Pesanan</label>
            <select id="status" name="status" class="text-input">
                <option value="4">Selesai</option>
            </select>
        </div>
        <hr class="custom-divider"/>
        <div class="w-100 justify-content-end d-flex">
            <a href="#" class="btn-add" id="btn-confirm">
                <span>Konfirmasi</span>
            </a>
        </div>

    </div>

@endsection

@section('js')
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script>
        var path = '/{{ request()->path() }}';
        var table;

        function generateTableKeranjang() {
            table = $('#table-data-cart').DataTable({
                ajax: {
                    type: 'GET',
                    url: path,
                    'data': function (d) {
                        d.status = 1
                    }
                },
                "aaSorting": [],
                "order": [],
                scrollX: true,
                responsive: true,
                paging: true,
                "fnDrawCallback": function (setting) {
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        orderable: false,
                        className: 'text-center middle-header',
                    },
                    {
                        data: 'product.gambar',
                        orderable: false,
                        className: 'middle-header text-center',
                        render: function (data) {
                            if (data !== null) {
                                return '<div class="w-100 d-flex justify-content-center">' +
                                    '<a href="' + data + '" target="_blank" class="box-product-image">' +
                                    '<img src="' + data + '" alt="product-image" />' +
                                    '</a>' +
                                    '</div>';
                            }
                            return '-';
                        }
                    },
                    {
                        data: 'product.nama',
                        className: 'middle-header',
                    },
                    {
                        data: 'qty',
                        className: 'middle-header text-center',
                        render: function (data) {
                            return data.toLocaleString('id-ID');
                        }
                    },

                    {
                        data: 'harga',
                        className: 'middle-header text-end',
                        render: function (data) {
                            return data.toLocaleString('id-ID');
                        }
                    },
                    {
                        data: 'total',
                        className: 'middle-header text-end',
                        render: function (data) {
                            return data.toLocaleString('id-ID');
                        }
                    },
                ],
            });
        }


        function eventSaveConfirmation() {
            $('#btn-confirm').on('click', function (e) {
                e.preventDefault();
                AlertConfirm('Konfirmasi', 'Apakah anda yakin ingin melakukan konfirmasi?', function () {
                    saveConfirmationHandler();
                })
            })
        }

        async function saveConfirmationHandler() {
            try {
                blockLoading(true);
                let status = $('#status').val();
                await $.post(path, {status});
                blockLoading(false);
                Swal.fire({
                    title: 'Success',
                    text: 'Berhasil melakukan konfirmasi data...',
                    icon: 'success',
                    timer: 700
                }).then(() => {
                    window.location.href = '/admin/pesanan';
                })
            } catch (e) {
                blockLoading(false);
                let error_message = JSON.parse(e.responseText);
                ErrorAlert('Error', error_message.message);
            }
        }

        $(document).ready(function () {
            generateTableKeranjang();
            eventSaveConfirmation();
        })
    </script>
@endsection
