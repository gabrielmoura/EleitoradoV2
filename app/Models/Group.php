<?php

namespace App\Models;

use App\Service\Trait\ChartScopeTrait;
use App\Service\Trait\HasPid;
use App\Service\Trait\HasTenant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Symfony\Component\Uid\Ulid;

class Group extends Model
{
    use ChartScopeTrait;
    use HasFactory;
    use HasPid;
    use HasTenant;
    use LogsActivity;
    use Searchable;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'tenant_id',
        'pid',
    ];

    protected $casts = [
        //        'pid' => Ulid::class,
    ];

    public function persons(): BelongsToMany
    {
        return $this->belongsToMany(Person::class, 'group_people', 'group_id', 'person_id');
    }

    public function scopeFindPid(Builder $query, string $pid): Builder
    {
        return $query->where('pid', Ulid::fromString($pid)->toRfc4122());
    }

    public function demands(): BelongsToMany
    {
        return $this->belongsToMany(Demand::class, 'demand_group', 'group_id', 'demand_id');
    }

    //    protected function makeAllSearchableUsing(Builder $query): Builder
    //    {
    //        return $query->whitoutGlobalScope(TenantScope::class);
    //    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
        // Chain fluent methods for configuration options
    }
}
