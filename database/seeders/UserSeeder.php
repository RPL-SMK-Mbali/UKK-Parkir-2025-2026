<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items  = [
            [
                'email' => 'owner@smkmbali.sch.id',
                'name' => 'Owner 1 Example',
                'password' => Hash::make('password'),
                'role' => 'owner'
            ],
            [
                'email' => 'admin@smkmbali.sch.id',
                'name' => 'Admin 1 Example',
                'password' => Hash::make('password'),
                'role' => 'admin'
            ],
            [
                'email' => 'petugas@smkmbali.sch.id',
                'name' => 'Petugas 1 Example',
                'password' => Hash::make('password'),
                'role' => 'petugas'
            ],
        ];

        foreach($items as $item) {
            User::create($item);
        }
    }
}
