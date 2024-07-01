<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $data = [
            'email' => 'pimpinan@gmail.com',
            'username' => 'pimpinan',
            'password' => Hash::make('pimpinan'),
            'role' => 'pimpinan'
        ];
        User::create($data);
    }
}
