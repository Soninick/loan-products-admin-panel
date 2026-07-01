<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        Role::query()->updateOrCreate(['name' => 'Admin']);
        Role::query()->updateOrCreate(['name' => 'Viewer']);
    }
}
