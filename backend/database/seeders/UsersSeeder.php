<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Services\EligibilityEngineService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $viewerRoleId = Role::query()->where('name', 'Viewer')->value('id');
        $eligibilityEngineService = app(EligibilityEngineService::class);

        $users = [
            [
                'email' => 'young.user@example.com',
                'name' => 'Young User',
                'role_id' => $viewerRoleId,
                'password' => Hash::make('password'),
                'dob' => '2005-01-20',
                'credit_score' => 720,
                'employment_type' => 'Salaried',
                'salary_type' => 'Monthly',
                'salary' => 70000,
            ],
            [
                'email' => 'self.employed@example.com',
                'name' => 'Self Employed User',
                'role_id' => $viewerRoleId,
                'password' => Hash::make('password'),
                'dob' => '1984-11-02',
                'credit_score' => 710,
                'employment_type' => 'Self Employed',
                'salary_type' => 'Yearly',
                'salary' => 85000,
            ],
            [
                'email' => 'low.score@example.com',
                'name' => 'Low Score User',
                'role_id' => $viewerRoleId,
                'password' => Hash::make('password'),
                'dob' => '1976-04-18',
                'credit_score' => 580,
                'employment_type' => 'Self Employed',
                'salary_type' => 'Yearly',
                'salary' => 100000,
            ],
        ];

        foreach ($users as $attributes) {
            $user = User::query()->updateOrCreate(
                ['email' => $attributes['email']],
                $attributes
            );

            $eligibilityEngineService->evaluateUser($user);
        }
    }
}
