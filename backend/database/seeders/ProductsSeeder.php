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
                'name' => 'Personal Loan',
                'description' => 'For salaried individuals with stable income and good credit history.',
                'min_age' => 21,
                'max_age' => 58,
                'min_credit_score' => 700,
                'allowed_employment_types' => ['Salaried'],
                'allowed_salary_types' => ['Monthly'],
                'min_salary' => 25000,
            ],
            [
                'name' => 'Business Loan',
                'description' => 'Designed for self employed applicants with stronger repayment capacity.',
                'min_age' => 25,
                'max_age' => 55,
                'min_credit_score' => 750,
                'allowed_employment_types' => ['Self Employed'],
                'allowed_salary_types' => ['Yearly'],
                'min_salary' => 50000,
            ],
            [
                'name' => 'Flexi Loan',
                'description' => 'Flexible loan option for both salaried and self employed applicants.',
                'min_age' => 23,
                'max_age' => 55,
                'min_credit_score' => 650,
                'allowed_employment_types' => ['Salaried', 'Self Employed'],
                'allowed_salary_types' => ['Monthly', 'Yearly'],
                'min_salary' => 30000,
            ],
        ];

        foreach ($products as $attributes) {
            Product::query()->updateOrCreate(
                ['name' => $attributes['name']],
                $attributes
            );
        }

        $eligibilityEngineService->evaluateAllUsers();
    }
}
