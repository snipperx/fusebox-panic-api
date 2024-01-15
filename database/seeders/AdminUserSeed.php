<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Alfred Pennyworth',
            'email' => 'alfred@gothampd.com',
            'password' => Hash::make('sysmtem@admin'),
            'role' => 'admin',
        ]);
    }
}
