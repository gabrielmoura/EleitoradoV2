<?php

namespace App\Models;

use App\Models\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Symfony\Component\Uid\Ulid;

class Event extends Model implements HasMedia
{
    use HasFactory;
    use LogsActivity;
    use InteractsWithMedia;
    use Searchable;

    protected $fillable = [
        'name',
        'pid',
        'description',
        'start_date',
        'end_date',
        'tenant_id',
        'address_id',
        'person_id',
        'group_id',
        'demands_id',
        'estimated_public',
    ];

    protected $casts = [
        'estimated_public' => 'integer',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

    public function persons(): BelongsToMany
    {
        return $this->belongsToMany(Person::class, 'event_people', 'event_id', 'person_id');
    }

    public function scopeFindPid(Builder $query, string $pid): Builder
    {
        return $query->where('pid', Ulid::fromString($pid)->toRfc4122());
    }

    public function getRouteKeyName(): string
    {
        return 'pid';
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new TenantScope);
    }

    protected static function boot(): void
    {
        parent::boot(); // TODO: Change the autogenerated stub
        static::creating(function ($model) {
            if (! app()->runningInConsole()) {
                $model->tenant_id = session()->get('tenant_id');
                $model->pid = Str::ulid()->toRfc4122();
            }
        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
    }
}
