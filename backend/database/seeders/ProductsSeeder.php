<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Services\EligibilityEngineService;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {
        $eligibilityEngineService = app(EligibilityEngineService::class);

        $products = [
            [
                'name' => 'Starter Loan',
                'description' => 'Basic loan product for younger salaried applicants.',
                'min_age' => 21,
                'max_age' => 40,
                'min_credit_score' => 600,
                'allowed_employment_types' => ['Salaried', 'Self Employed'],
                'allowed_salary_types' => ['Monthly'],
                'min_salary' => 50000,
            ],
            [
                'name' => 'Growth Loan',
                'description' => 'Higher value loan product for stable applicants.',
                'min_age' => 25,
                'max_age' => 55,
                'min_credit_score' => 700,
                'allowed_employment_types' => ['Salaried'],
                'allowed_salary_types' => ['Monthly', 'Yearly'],
                'min_salary' => 90000,
            ],
            [
                'name' => 'Flex Loan',
                'description' => 'Loan product for self employed applicants.',
                'min_age' => 30,
                'max_age' => 60,
                'min_credit_score' => 650,
                'allowed_employment_types' => ['Self Employed'],
                'allowed_salary_types' => ['Yearly'],
                'min_salary' => 80000,
            ],
        ];

        foreach ($products as $attributes) {
            Product::query()->updateOrCreate(
                ['name' => $attributes['name']],
                $attributes
            );

            $eligibilityEngineService->evaluateAllUsers();
        }
    }
}
