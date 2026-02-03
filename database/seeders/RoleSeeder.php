<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Enums\RoleEnum;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(): void
    {
        Role::firstOrCreate([
            'name' => 'ADMINISTRATOR',
        ],[
            'name' => 'ADMINISTRATOR',
            'guard_name' => 'web',
        ]);

        Role::firstOrCreate([
            'name' => 'CUSTOMER',
        ],[
            'name' => 'CUSTOMER',
            'guard_name' => 'web',
        ]);
    }
}
