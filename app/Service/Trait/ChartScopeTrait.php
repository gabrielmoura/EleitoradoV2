<?php

namespace App\Service\Trait;

use Illuminate\Database\Eloquent\Builder;

trait ChartScopeTrait
{
    /**
     * @param Builder $query
     * @param string $year
     * @return Builder
     */
    public function scopeGetYears(Builder $query, string $year): Builder
    {
        return $query->whereYear('created_at', $year);
    }

    public function scopeTotalByMonth(Builder $query): array
    {
        return $query->selectRaw('count(*) as total, month(created_at) as month')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->values()
            ->toArray();
    }
}
