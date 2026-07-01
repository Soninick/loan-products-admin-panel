<?php

namespace App\Services;

use App\Models\EligibleProduct;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;

class EligibilityEngineService
{
    public function evaluateUser(User $user): void
    {
        $qualifiedProducts = Product::query()
            ->get()
            ->filter(function (Product $product) use ($user) {
                return $this->qualifies($user, $product);
            });

        EligibleProduct::query()
            ->where('user_id', $user->id)
            ->delete();

        foreach ($qualifiedProducts as $product) {
            EligibleProduct::query()->create([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);
        }

        $user->update([
            'status' => $qualifiedProducts->isNotEmpty() ? 'Active' : 'Rejected',
        ]);
    }

    public function evaluateAllUsers(): void
    {
        User::query()->get()->each(function (User $user) {
            $this->evaluateUser($user);
        });
    }

    private function qualifies(User $user, Product $product): bool
    {
        $age = Carbon::parse($user->dob)->age;

        if ($age < $product->min_age || $age > $product->max_age) {
            return false;
        }

        if ($user->credit_score < $product->min_credit_score) {
            return false;
        }

        if (! in_array($user->employment_type, $product->allowed_employment_types ?? [], true)) {
            return false;
        }

        if (! in_array($user->salary_type, $product->allowed_salary_types ?? [], true)) {
            return false;
        }

        if ((float) $user->salary < (float) $product->min_salary) {
            return false;
        }

        return true;
    }
}
