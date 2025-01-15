<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Branch;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cabang Pusat
        Branch::create([
            'name' => 'Cabang Pusat',
            'telephone' => '081234567890',
            'address' => 'Jl. Desa Bendungan - Kuningan',
        ]);

        // Cabang Bendungan
        Branch::create([
            'name' => 'Cabang Luragung',
            'telephone' => '081234567890',
            'address' => 'Jl. Raya Luragung - Kuningan',
        ]);
    }
}
