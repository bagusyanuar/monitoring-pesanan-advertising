@extends('admin.layout')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-1">
        <div>
            <p class="content-title">Customer</p>
            <p class="content-sub-title">Daftar data customer</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Customer</li>
            </ol>
        </nav>
    </div>
    <div class="card-content">
        <div class="content-header mb-3">
            <p class="header-title">Data Customer</p>
        </div>
        <hr class="custom-divider"/>
        <table id="table-data" class="display table w-100">
            <thead>
            <tr>
                <th width="5%" class="text-center">#</th>
                <th width="15%" class="text-center">Email</th>
                <th width="15%" class="text-center">Username</th>
                <th>Nama</th>
                <th width="15%" class="text-center">No. Hp</th>
                <th width="10%" class="text-center"></th>
            </tr>
            </thead>
        </table>
    </div>
@endsection

@section('js')
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script>
        var path = '/{{ request()->path() }}';
        var table;

        function generateTable() {
            table = $('#table-data').DataTable({
                ajax: {
                    type: 'GET',
                    url: path,
                    // 'data': data
                },
                "aaSorting": [],
                "order": [],
                scrollX: true,
                responsive: true,
                paging: true,
                "fnDrawCallback": function (setting) {
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false, className: 'text-center middle-header',},
                    {
                        data: 'user.email',
                        className: 'middle-header text-center',
                    },
                    {
                        data: 'user.username',
                        className: 'middle-header text-center',
                    },
                    {
                        data: 'nama',
                        className: 'middle-header',
                    },
                    {
                        data: 'no_hp',
                        className: 'middle-header text-center',
                    },
                    {
                        data: 'no_hp',
                        orderable: false,
                        className: 'text-center middle-header',
                        render: function (data) {
                            let urlWhatsapp = 'https://wa.me/' + data;
                            return '<div class="w-100 d-flex justify-content-center align-items-center gap-1">' +
                                '<a target="_blank" style="text-decoration: none; color: forestgreen; font-size: 2em;" href="' + urlWhatsapp + '" class=""><i class="bx bxl-whatsapp"></i></a>' +
                                '</div>';
                        }
                    }
                ],
            });
        }


        $(document).ready(function () {
            generateTable();
        })
    </script>
@endsection
