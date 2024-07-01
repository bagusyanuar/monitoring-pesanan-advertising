<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Keranjang;
use App\Models\Penjualan;

class PesananController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $status = $this->field('status');
            $data = [];
            if ($status === '1') {
                $data = Penjualan::with([])
                    ->where('status', '=', 1)
                    ->orderBy('updated_at', 'ASC')
                    ->get();
            }
            return $this->basicDataTables($data);
        }
        return view('admin.pesanan.index');
    }

    public function detail_new($id)
    {
//        if ($this->request->ajax()) {
//            if ($this->request->method() === 'POST') {
//                return $this->confirm_order($id);
//            }
//            $data = Keranjang::with(['product'])
//                ->where('penjualan_id', '=', $id)
//                ->get();
//            return $this->basicDataTables($data);
//        }
        $data = Penjualan::with(['pembayaran_status', 'keranjang'])
            ->findOrFail($id);
        return view('admin.pesanan.detail.baru')->with([
            'data' => $data
        ]);
    }
}
