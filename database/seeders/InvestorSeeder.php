<?php

namespace Database\Seeders;

use App\Models\Investor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvestorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $datas = [
            ['name' => 'Investor1'],
            ['name' => 'Investor2'],
            ['name' => 'Investor3'],
            ['name' => 'Investor4'],
            ['name' => 'Investor5'],
        ];

        foreach ($datas as $data) {
            Investor::create($data);
        }
    }
}
