<?php


namespace App\Http\Controllers\Customer;


use App\Helper\CustomController;

class RegisterController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    private $rule = [
        'email' => 'required|email',
        'username' => 'required',
        'password' => 'required',
        'phone' => 'required',
    ];

    private $message = [
        'email.required' => 'kolom email wajib di isi',
        'email.email' => 'alamat email tidak valid',
        'username.required' => 'kolom usernam wajib di isi',
        'password.required' => 'kolom password wajib di isi',
        'phone.required' => 'kolom no hp wajib di isi',
    ];

    public function register()
    {
        return view('customer.register');
    }
}
