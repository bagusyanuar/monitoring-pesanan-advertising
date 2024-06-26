<?php


namespace App\Http\Controllers\Customer;


use App\Helper\CustomController;
use App\Models\Product;

class ProductController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            try {
                $q = $this->request->query->get('param');
                $query = Product::with([]);
                $products = $query->where('nama', 'LIKE', '%' . $q . '%')
                    ->get();
                return $this->jsonSuccessResponse('success', $products);
            } catch (\Exception $e) {
                return $this->jsonErrorResponse('internal server error...');
            }
        }
        return view('customer.product.index');
    }

    public function detail($id)
    {
        $product = Product::with([])
            ->where('id', '=', $id)
            ->firstOrFail();
        return view('customer.product.detail')->with(['product' => $product]);
    }
}
