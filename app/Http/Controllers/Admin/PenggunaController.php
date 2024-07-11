<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PenggunaController extends CustomController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $data = Admin::with(['user'])
                ->get();
            return $this->basicDataTables($data);
        }
        return view('admin.pengguna.index');
    }

    public function add()
    {
        if ($this->request->method() === 'POST') {
            return $this->store();
        }
        return view('admin.pengguna.add');
    }

    public function edit($id)
    {
        $data = Admin::with(['user'])
            ->findOrFail($id);
        if ($this->request->method() === 'POST') {
            return $this->patch($data);
        }
        return view('admin.pengguna.edit')->with(['data' => $data]);
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $data = Admin::with(['user'])
                ->where('id', '=', $id)
                ->first();
            if (!$data) {
                return $this->jsonNotFoundResponse('user not found');
            }
            $userID = $data->user_id;
            $data->delete();
            User::destroy($userID);
            DB::commit();
            return $this->jsonSuccessResponse('Berhasil menghapus data...');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->jsonErrorResponse();
        }
    }

    private $rule = [
        'password' => 'required',
        'username' => 'required',
        'email' => 'required',
        'name' => 'required',
    ];

    private $message = [
        'username.required' => 'kolom username wajib diisi',
        'password.required' => 'kolom password wajib diisi',
        'name.required' => 'kolom nama wajib diisi',
        'email.required' => 'kolom email wajib diisi',
    ];

    private function store()
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($this->request->all(), $this->rule, $this->message);
            if ($validator->fails()) {
                return redirect()->back()->with('failed', 'Harap mengisi kolom dengan benar...')->withErrors($validator)->withInput();
            }
            $data_user = [
                'email' => $this->postField('email'),
                'username' => $this->postField('username'),
                'password' => Hash::make($this->postField('password')),
                'role' => 'admin',
            ];

            $user = User::create($data_user);

            $data_admin = [
                'user_id' => $user->id,
                'nama' => $this->postField('name')
            ];
            Admin::create($data_admin);
            DB::commit();
            return redirect()->back()->with('success', 'Berhasil menyimpan data admin...');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('failed', 'terjadi kesalahan server...');
        }
    }

    /**
     * @param Model $data
     * @return \Illuminate\Http\RedirectResponse
     */
    private function patch($data)
    {
        try {
            DB::beginTransaction();
            $newRule = Arr::except($this->rule, ['password']);
            $validator = Validator::make($this->request->all(), $newRule, $this->message);
            if ($validator->fails()) {
                return redirect()->back()->with('failed', 'Harap mengisi kolom dengan benar...')->withErrors($validator)->withInput();
            }
            $data_user = [
                'email' => $this->postField('email'),
                'username' => $this->postField('username'),
            ];

            if ($this->postField('password') !== '') {
                $data_user['password'] = Hash::make($this->postField('password'));
            }

            /** @var Model $user */
            $user = $data->user;
            $user->update($data_user);

            $data_dokter = [
                'nama' => $this->postField('name')
            ];

            $data->update($data_dokter);
            DB::commit();
            return redirect()->back()->with('success', 'Berhasil merubah data dokter...');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('failed', 'terjadi kesalahan server...');
        }
    }
}
