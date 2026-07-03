<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Services\EligibilityEngineService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ViewerSeeder extends Seeder
{
    public function run(): void
    {
        $viewerRoleId = Role::query()->where('name', 'Viewer')->value('id');

        $user = User::query()->updateOrCreate(
            ['email' => 'viewer@example.com'],
            [
                'role_id' => $viewerRoleId,
                'name' => 'Viewer User',
                'password' => Hash::make('password'),
                'dob' => '1998-08-15',
                'credit_score' => 660,
                'employment_type' => 'Salaried',
                'salary_type' => 'Monthly',
                'salary' => 60000,
            ]
        );

        app(EligibilityEngineService::class)->evaluateUser($user);
    }
}
