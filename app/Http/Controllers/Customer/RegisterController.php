<?php


namespace App\Http\Controllers\Customer;


use App\Helper\CustomController;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
        if ($this->request->method() === 'POST') {
            try {
                $validator = Validator::make($this->request->all(), $this->rule, $this->message);
                if ($validator->fails()) {
                    return redirect()->back()->with('failed', 'harap mengisi kolom dengan benar...')->withErrors($validator)->withInput();
                }
                $data_account = [
                    'email' => $this->postField('email'),
                    'username' => $this->postField('username'),
                    'password' => Hash::make($this->postField('password')),
                    'role' => 'customer'
                ];
                DB::beginTransaction();
                $user = User::create($data_account);
                $data_customer = [
                    'user_id' => $user->id,
                    'nama' => $this->postField('name'),
                    'no_hp' => $this->postField('phone')
                ];
                Customer::create($data_customer);
                DB::commit();
                Auth::loginUsingId($user->id);
                return redirect()->back()->with('success', 'Berhasil melakukan registrasi');
            }catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('failed', 'terjadi kesalahan server...')->withInput();
            }
        }
        return view('customer.register');
    }
}
