<?php


namespace App\Http\Controllers\Customer;


use App\Helper\CustomController;
use App\Models\Product;

class BerandaController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $products = Product::with([])
            ->orderBy('created_at', 'DESC')
            ->get();
        return view('customer.beranda')->with([
            'products' => $products
        ]);
    }
}
