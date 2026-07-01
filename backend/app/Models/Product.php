<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'min_age',
        'max_age',
        'min_credit_score',
        'allowed_employment_types',
        'allowed_salary_types',
        'min_salary',
    ];

    protected function casts(): array
    {
        return [
            'allowed_employment_types' => 'array',
            'allowed_salary_types' => 'array',
            'min_salary' => 'decimal:2',
        ];
    }

    public function eligibleProducts(): HasMany
    {
        return $this->hasMany(EligibleProduct::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'eligible_products')->withTimestamps();
    }
}
