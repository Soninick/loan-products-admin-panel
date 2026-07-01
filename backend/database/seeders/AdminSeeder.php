<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Services\EligibilityEngineService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $adminRoleId = Role::query()->where('name', 'Admin')->value('id');

        $user = User::query()->updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'role_id' => $adminRoleId,
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'dob' => '1990-05-10',
                'credit_score' => 780,
                'employment_type' => 'Salaried',
                'salary_type' => 'Monthly',
                'salary' => 120000,
            ]
        );

        app(EligibilityEngineService::class)->evaluateUser($user);
    }
}
