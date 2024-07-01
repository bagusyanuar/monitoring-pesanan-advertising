<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Customer;

class CustomerController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $data = Customer::with(['user'])
                ->get();
            return $this->basicDataTables($data);
        }
        return view('admin.customer.index');
    }
}
