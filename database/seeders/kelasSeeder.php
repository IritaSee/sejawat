<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class kelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kelas = [
            [
                'id' => '999',
                'nama_kelas' => 'Waiting List',
                'created_at' => now(),
            ]
        ];
        DB::table('kelas')->insert($kelas);
    }
}
