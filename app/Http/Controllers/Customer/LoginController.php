<?php


namespace App\Http\Controllers\Customer;


use App\Helper\CustomController;

class LoginController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function login()
    {
        return view('customer.login');
    }
}
