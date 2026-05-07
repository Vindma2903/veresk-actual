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
        $admin = new User([
            'name' => 'michelle',
            'email' => '1acco@mail.ru',
            'password' => Hash::make('123123123'),
            'is_admin' => true,
        ]);
        $admin->save();
    }
}
