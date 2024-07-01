<?php


namespace App\Http\Controllers\Customer;


use App\Helper\CustomController;
use App\Models\BiayaPengiriman;
use App\Models\Keranjang;
use App\Models\Penjualan;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class KeranjangController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->method() === 'POST' && $this->request->ajax()) {
            return $this->addToCart();
        }

        /** @var Collection $carts */
        $carts = Keranjang::with(['product'])
            ->whereNull('penjualan_id')
            ->where('user_id', '=', auth()->id())
            ->get();
        $subTotal = 0;
        if (count($carts) > 0) {
            $subTotal = $carts->sum('total');
        }
        return view('customer.keranjang')->with([
            'carts' => $carts,
            'subTotal' => $subTotal,
        ]);
    }

    private function addToCart()
    {
        try {
            $userID = auth()->id();
            $productID = $this->postField('id');
            $qty = $this->postField('qty');

            $product = Product::with([])
                ->where('id', '=', $productID)
                ->firstOrFail();
            if (!$product) {
                return $this->jsonErrorResponse('product tidak ditemukan');
            }

            $bySize = $product->harga_ukuran;
            $productPrice = $product->harga;
            $total = (int) $qty * $productPrice;
            if ($bySize) {
                $dimension = (int) $this->postField('width') * (int) $this->postField('height');
                $total = (int) $qty * $productPrice * $dimension;
            }
            $data_request = [
                'user_id' => $userID,
                'penjualan_id' => null,
                'product_id' => $productID,
                'qty' => $qty,
                'harga' => $productPrice,
                'total' => $total,
                'desain' => null,
                'panjang' => 0,
                'lebar' => 0
            ];

            if ($bySize) {
                $data_request['panjang'] = $this->postField('width');
                $data_request['lebar'] = $this->postField('height');
            }
            Keranjang::create($data_request);
            return $this->jsonSuccessResponse('success', 'Berhasil menambahkan keranjang...');
        }catch (\Exception $e) {
            return $this->jsonErrorResponse();
        }
    }

    public function delete($id)
    {
        try {
            Keranjang::destroy($id);
            return $this->jsonSuccessResponse('Berhasil menghapus data...');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse();
        }
    }

    public function checkout()
    {
        try {
            DB::beginTransaction();
            $userID = auth()->id();

            $transactionRef = 'HP-'.date('YmdHis');
            /** @var Collection $carts */
            $carts = Keranjang::with(['product'])
                ->whereNull('penjualan_id')
                ->where('user_id', '=', auth()->id())
                ->get();

            if (count($carts) <= 0) {
                return $this->jsonErrorResponse('belum ada data belanja...');
            }

            $total = $carts->sum('total');
            $data_request = [
                'user_id' => $userID,
                'tanggal' => Carbon::now()->format('Y-m-d'),
                'no_penjualan' => $transactionRef,
                'total' => $total,
                'status' => 0,
            ];

            $transaction = Penjualan::create($data_request);
            /** @var Model $cart */
            foreach ($carts as $cart) {
                $cart->update(['penjualan_id' => $transaction->id]);
            }
            $transID = $transaction->id;
            DB::commit();
            return $this->jsonSuccessResponse('success', $transID);
        }catch (\Exception $e) {
            return $this->jsonErrorResponse($e->getMessage());
        }
    }

}
