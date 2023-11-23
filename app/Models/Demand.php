<?php

namespace App\Models;

use App\Events\Demand\DemandClosedEvent;
use App\Events\Demand\DemandCreatedEvent;
use App\Service\Trait\ChartScopeTrait;
use App\Service\Trait\HasPid;
use App\Service\Trait\HasTenant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Scout\Searchable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Symfony\Component\Uid\Ulid;

class Demand extends Model implements HasMedia
{
    use ChartScopeTrait;
    use HasFactory;
    use HasPid;
    use HasTenant;
    use InteractsWithMedia;
    use LogsActivity;
    use Searchable;

    protected $fillable = [
        'name',
        'description',
        'tenant_id',
        'priority',
        'active',
        'demand_type_id',
        'status',
        'solution_date',
        'closed_at',
        'priority',
    ];

    protected $casts = [
        'solution_date' => 'date:d/m/Y',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'closed_at' => 'datetime',
        'active' => 'boolean',
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(DemandType::class, 'demand_type_id', 'id');
    }

    public function scopeFindPid(Builder $query, string $pid): Builder
    {
        return $query->where('pid', Ulid::fromString($pid)->toRfc4122());
    }

    protected $dispatchesEvents = [
        'created' => DemandCreatedEvent::class,
        //        'updated' => \App\Events\System\DemandClosedEvent::class,
    ];

    public function persons(): BelongsToMany
    {
        return $this->belongsToMany(Person::class, 'demand_people', 'demand_id', 'person_id');
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'demand_group', 'demand_id', 'group_id');
    }

    protected static function boot(): void
    {
        parent::boot();
        static::updating(function ($model) {
            if ($model->status == 'closed') {
                event(new DemandClosedEvent($model));
            }
        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
        // Chain fluent methods for configuration options
    }
}
