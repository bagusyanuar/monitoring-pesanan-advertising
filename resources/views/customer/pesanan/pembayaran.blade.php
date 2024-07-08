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
    <div class="lazy-backdrop" id="overlay-loading">
        <div class="d-flex flex-column justify-content-center align-items-center">
            <div class="spinner-border text-light" role="status">
            </div>
            <p class="text-light">Sedang Menyimpan Data...</p>
        </div>
    </div>
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
    <div class="w-100" style="padding-left: 25px">
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
                        @if($data->status === 0 || $data->status === 5)
                            <div class="chip-status-danger">menunggu pembayaran</div>
                        @endif
                </span>
            </div>
        </div>
        <hr class="custom-divider"/>
        <div class="d-flex w-100 gap-3">
            <div class="flex-grow-1 d-flex gap-2">
                <div class="w-100 d-flex justify-content-center align-items-center">
                    <img src="{{ asset('/assets/images/payment-bg.png') }}" alt="payment-image">
                </div>
            </div>
            <div class="card-content" style="width: 400px; height: fit-content;">
                <p style="font-size: 1em; font-weight: bold; color: var(--dark);">Pembayaran</p>
                <hr class="custom-divider"/>
                <div class="d-flex align-items-center justify-content-between mb-1" style="font-size: 1em;">
                    <span style="color: var(--dark); font-size: 0.8em">Total</span>
                    <span id="lbl-total"
                          style="color: var(--dark); font-weight: bold;">Rp{{ number_format($data->total, 0, ',', '.') }}</span>
                </div>
                <hr class="custom-divider"/>
                <form method="post" id="form-data">
                    @csrf
                    <div class="w-100 mb-2">
                        <label for="bank" class="form-label input-label">Bank</label>
                        <select id="bank" name="bank" class="text-input">
                            <option value="BRI">BRI (91283948124)</option>
                            <option value="BCA">BCA (99829948499)</option>
                            <option value="MANDIRI">MANDIRI (12984912885)</option>
                        </select>
                    </div>
                    <div class="w-100 mb-2">
                        <label for="name" class="form-label input-label">Atas Nama</label>
                        <input type="text" placeholder="atas nama" class="text-input" id="name"
                               name="name">
                    </div>
                    <div class="w-100">
                        <label for="document-dropzone" class="form-label input-label">Bukti Transfer</label>
                        <div class="w-100 needsclick dropzone mb-3" id="document-dropzone"></div>
                    </div>
                </form>
                <hr class="custom-divider"/>
                <a href="#" class="btn-action-primary" id="btn-save">Upload</a>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link href="{{ asset('/css/dropzone.min.css') }}" rel="stylesheet"/>
@endsection

@section('js')
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script src="{{ asset('/js/dropzone.min.js') }}"></script>
    <script>
        var path = '/{{ request()->path() }}';
        var uploadedDocumentMap = {};
        var myDropzone;
        Dropzone.autoDiscover = false;
        Dropzone.options.documentDropzone = {
            success: function (file, response) {
                $('#form').append('<input type="hidden" name="files[]" value="' + file.name + '">');
                console.log(response);
                uploadedDocumentMap[file.name] = response.name
            },
        };

        function setupDropzone() {
            $('#document-dropzone').dropzone({
                url: path,
                maxFilesize: 5,
                addRemoveLinks: true,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                },
                autoProcessQueue: false,
                paramName: "file",
                init: function () {
                    myDropzone = this;
                    $('#btn-save').on('click', function (e) {
                        e.preventDefault();
                        Swal.fire({
                            title: "Konfirmasi!",
                            text: "Apakah anda yakin ingin menyimpan data?",
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya',
                            cancelButtonText: 'Batal',
                        }).then((result) => {
                            if (result.value) {
                                blockLoading(true);
                                if (myDropzone.files.length > 0) {
                                    myDropzone.processQueue();
                                } else {
                                    let frm = $('#form-data')[0];
                                    let f_data = new FormData(frm);
                                    $.ajax({
                                        type: "POST",
                                        enctype: 'multipart/form-data',
                                        url: path,
                                        data: f_data,
                                        processData: false,
                                        contentType: false,
                                        cache: false,
                                        timeout: 600000,
                                        success: function (data) {
                                            blockLoading(false);
                                            Swal.fire({
                                                title: 'Berhasil',
                                                text: 'Berhasil Menyimpan data...',
                                                icon: 'success',
                                                timer: 700
                                            }).then(() => {
                                                window.location.href = '/pesanan';
                                            });
                                        },
                                        error: function (e) {
                                            blockLoading(false);
                                            Swal.fire({
                                                title: 'Ooops',
                                                text: 'Gagal Menyimpan Data...',
                                                icon: 'error',
                                                timer: 700
                                            });
                                        }
                                    })
                                }
                            }
                        });
                    });
                    this.on('sending', function (file, xhr, formData) {
                        // Append all form inputs to the formData Dropzone will POST
                        var data = $('#form-data').serializeArray();
                        $.each(data, function (key, el) {
                            formData.append(el.name, el.value);
                        });
                    });

                    this.on('success', function (file, response) {
                        blockLoading(false);
                        Swal.fire({
                            title: 'Berhasil',
                            text: 'Berhasil Menyimpan data...',
                            icon: 'success',
                            timer: 700
                        }).then(() => {
                            window.location.href = '/pesanan';
                        });
                    });

                    this.on('error', function (file, response) {
                        blockLoading(false);
                        Swal.fire({
                            title: 'Ooops',
                            text: 'Gagal Menyimpan Data...',
                            icon: 'error',
                            timer: 700
                        });
                    });

                    this.on('addedfile', function (file) {
                        if (this.files.length > 1) {
                            this.removeFile(this.files[0]);
                        }
                    });
                },
            })
        }

        $(document).ready(function () {
            setupDropzone();
        })
    </script>
@endsection
