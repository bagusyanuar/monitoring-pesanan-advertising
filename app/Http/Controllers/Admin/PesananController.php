<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Keranjang;
use App\Models\Penjualan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

            if ($status === '2') {
                $data = Penjualan::with(['user.customer'])
                    ->where('status', '=', 2)
                    ->orderBy('updated_at', 'ASC')
                    ->get();
            }

            if ($status === '3') {
                $data = Penjualan::with(['user.customer'])
                    ->where('status', '=', 3)
                    ->orderBy('updated_at', 'ASC')
                    ->get();
            }

            if ($status === '4') {
                $data = Penjualan::with(['user.customer'])
                    ->where('status', '=', 4)
                    ->orderBy('updated_at', 'ASC')
                    ->get();
            }
            return $this->basicDataTables($data);
        }
        return view('admin.pesanan.index');
    }

    public function detail_new($id)
    {
        if ($this->request->ajax()) {
            if ($this->request->method() === 'POST') {
                return $this->confirm_order($id);
            }
            $data = Keranjang::with(['product'])
                ->where('penjualan_id', '=', $id)
                ->get();
            return $this->basicDataTables($data);
        }
        $data = Penjualan::with(['pembayaran_status', 'keranjang', 'user'])
            ->findOrFail($id);
        return view('admin.pesanan.detail.baru')->with([
            'data' => $data
        ]);
    }

    public function detail_process($id)
    {
        if ($this->request->ajax()) {
            if ($this->request->method() === 'POST') {
                return $this->change_process_status($id);
            }
            $data = Keranjang::with(['product'])
                ->where('penjualan_id', '=', $id)
                ->get();
            return $this->basicDataTables($data);
        }
        $data = Penjualan::with(['pembayaran_status', 'keranjang', 'user'])
            ->findOrFail($id);
        return view('admin.pesanan.detail.proses')->with([
            'data' => $data
        ]);
    }

    public function detail_finish($id)
    {
        if ($this->request->ajax()) {
            $data = Keranjang::with(['product'])
                ->where('penjualan_id', '=', $id)
                ->get();
            return $this->basicDataTables($data);
        }
        $data = Penjualan::with(['pembayaran_status', 'keranjang', 'user'])
            ->findOrFail($id);
        return view('admin.pesanan.detail.selesai')->with([
            'data' => $data
        ]);
    }

    public function detail_take($id)
    {
        if ($this->request->ajax()) {
            if ($this->request->method() === 'POST') {
                return $this->change_process_status($id);
            }
            $data = Keranjang::with(['product'])
                ->where('penjualan_id', '=', $id)
                ->get();
            return $this->basicDataTables($data);
        }
        $data = Penjualan::with(['pembayaran_status', 'keranjang', 'user'])
            ->findOrFail($id);
        return view('admin.pesanan.detail.siap-diambil')->with([
            'data' => $data
        ]);
    }

    private function confirm_order($id)
    {
        DB::beginTransaction();
        try {
            $status = $this->postField('status');
            $reason = $this->postField('reason');
            $order = Penjualan::with(['pembayaran_status'])
                ->where('id', '=', $id)
                ->first();
            if (!$order) {
                return $this->jsonNotFoundResponse('data tidak ditemukan...');
            }

            /** @var Model $payment */
            $payment = $order->pembayaran_status;
            $data_request_order = [
                'status' => 5,
            ];
            if ($status === '1') {
                $data_request_order['status'] = 2;
            }

            $data_request_payment = [
                'status' => 2,
                'deskripsi' => $reason
            ];
            if ($status === '1') {
                $data_request_payment['status'] = 1;
                $data_request_payment['deskripsi'] = null;
            }
            $payment->update($data_request_payment);
            $order->update($data_request_order);
            DB::commit();
            return $this->jsonSuccessResponse('success', 'Berhasil melakukan konfirmasi...');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->jsonErrorResponse($e->getMessage());
        }
    }

    private function change_process_status($id)
    {
        try {
            $status = $this->postField('status');
            $order = Penjualan::with([])
                ->where('id', '=', $id)
                ->first();
            if (!$order) {
                return $this->jsonNotFoundResponse('data tidak ditemukan...');
            }
            $data_request_order = [
                'status' => $status,
            ];
            $order->update($data_request_order);
            return $this->jsonSuccessResponse('success', 'Berhasil merubah data product...');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse($e->getMessage());
        }
    }
}
