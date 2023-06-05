<?php

namespace App\Models;

use App\Events\Demand\DemandClosedEvent;
use App\Events\Demand\DemandCreatedEvent;
use App\Models\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Demand extends Model implements HasMedia
{
    use HasFactory;
    use LogsActivity;
    use InteractsWithMedia;

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
        return $this->belongsTo(DemandType::class);
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new TenantScope);
    }

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($model) {
            if (! app()->runningInConsole()) {
                $model->tenant_id = session()->get('tenant_id');
            }
            event(new DemandCreatedEvent($model));
        });
        static::updating(function ($model) {
            if ($model->status == 'closed') {
                event(new DemandClosedEvent($model));
            }
        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
        // Chain fluent methods for configuration options
    }
}
