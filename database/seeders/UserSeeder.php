<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            ['name' => 'Admin', 'email' => 'admin@gmail.com', 'password' => bcrypt('12345678')],
            ['name' => 'User', 'email' => 'user@gmail.com', 'password' => bcrypt('12345678')],
        ];

        foreach ($datas as $data) {
            User::create($data);
        }
    }
}
