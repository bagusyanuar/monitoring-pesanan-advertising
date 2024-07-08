<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Penjualan;

class LaporanController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $start = $this->field('start');
            $end = $this->field('end');
            $data = Penjualan::with(['user.customer'])
                ->where('status', '=', 4)
                ->whereBetween('tanggal', [$start, $end])
                ->orderBy('updated_at', 'ASC')
                ->get();
            return $this->basicDataTables($data);
        }
        return view('admin.laporan.penjualan');
    }

    public function pdf()
    {
        $start = $this->field('start');
        $end = $this->field('end');
        $data = Penjualan::with(['user.customer'])
            ->where('status', '=', 4)
            ->whereBetween('tanggal', [$start, $end])
            ->orderBy('updated_at', 'ASC')
            ->get();
        return $this->convertToPdf('admin.laporan.cetak-penjualan', [
            'data' => $data,
            'start' => $start,
            'end' => $end
        ]);

    }
}
