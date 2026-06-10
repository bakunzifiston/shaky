<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExpenseCategory extends Model
{
    public const TYPE_COGS = 'cogs';

    public const TYPE_OPERATING = 'operating';

    protected $fillable = [
        'name',
        'type',
    ];

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function scopeOfType(Builder $query, string $type): Builder
    {
        return $query->where('type', $type);
    }

    public function typeLabel(): string
    {
        return match ($this->type) {
            self::TYPE_COGS => 'COGS',
            self::TYPE_OPERATING => 'Operating',
            default => ucfirst((string) $this->type),
        };
    }
}
