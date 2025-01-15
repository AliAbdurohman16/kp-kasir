<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Branch;
use Laravolt\Avatar\Facade as Avatar;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // owner
        $ownerAvatar = $this->createAvatar('Owner');
        
        $owner = User::create([
            'avatar' => $ownerAvatar,
            'name' => 'Owner',
            'email' => 'owner@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('1234567890'),
        ])->assignRole('owner');

        // admin
        $admins = [
            [
                'name' => 'Admin Cabang Pusat',
                'email' => 'admin.pusat@gmail.com',
                'branch_name' => 'Cabang Pusat',
            ],
            [
                'name' => 'Admin Cabang Luragung',
                'email' => 'admin.bendungan@gmail.com',
                'branch_name' => 'Cabang Luragung',
            ],
        ];

        foreach ($admins as $adminData) {
            $branch = Branch::where('name', $adminData['branch_name'])->first();
            $adminAvatar = $this->createAvatar($adminData['name']);
            $admin = User::create([
                'avatar' => $adminAvatar,
                'name' => $adminData['name'],
                'email' => $adminData['email'],
                'email_verified_at' => now(),
                'password' => bcrypt('1234567890'),
                'branch_id' => $branch ? $branch->id : null,
            ]);
            $admin->assignRole('admin');
        }

        // kepala-toko
        $kepalaTokos = [
            [
                'name' => 'Kepala Toko Cabang Pusat',
                'email' => 'kepalatoko.pusat@gmail.com',
                'branch_name' => 'Cabang Pusat',
            ],
            [
                'name' => 'Kepala Toko Cabang Luragung',
                'email' => 'kepalatoko.bendungan@gmail.com',
                'branch_name' => 'Cabang Luragung',
            ],
        ];

        foreach ($kepalaTokos as $kepalaTokoData) {
            $branch = Branch::where('name', $kepalaTokoData['branch_name'])->first();
            $kepalaTokoAvatar = $this->createAvatar($kepalaTokoData['name']);
            $kepalaToko = User::create([
                'avatar' => $kepalaTokoAvatar,
                'name' => $kepalaTokoData['name'],
                'email' => $kepalaTokoData['email'],
                'email_verified_at' => now(),
                'password' => bcrypt('1234567890'),
                'branch_id' => $branch ? $branch->id : null,
            ]);
            $kepalaToko->assignRole('kepala-toko');
        }
    }

    protected function createAvatar($name)
    {
        $avatarImage = Avatar::create(strtoupper($name[0]))
            ->setBackground(sprintf('#%06X', mt_rand(0, 0xFFFFFF))) // Random background color
            ->setDimension(100, 100) // Avatar size
            ->getImageObject(); // Generates the image as a GD object

        $avatarName = Str::random(10) . '.png';
        $avatarPath = 'avatars/' . $avatarName;

        Storage::disk('public')->put($avatarPath, $avatarImage->encode('png'));

        return basename($avatarPath);
    }
}
