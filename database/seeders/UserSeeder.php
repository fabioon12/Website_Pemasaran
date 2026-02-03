<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Enums\RoleEnum;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
       public function run(): void
    {
        $now = Carbon::now();

        $administrator = User::firstOrCreate([
            'email' => 'admin@gmail.com',
        ],[
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $administrator->assignRole(RoleEnum::ADMINISTRATOR);

        $customer = User::firstOrCreate([
            'email' => 'stu@gmail.com',
        ],[
            'name' => 'Customer',
            'email' => 'student@gmail.com',
            'password' => Hash::make('password'),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $customer->assignRole(RoleEnum::CUSTOMER);
    }
}
