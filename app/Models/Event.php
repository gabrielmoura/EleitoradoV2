<?php

namespace App\Models;

use App\Actions\Tools\CalendarLink;
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

class Event extends Model implements HasMedia
{
    use HasFactory;
    use HasPid;
    use HasTenant;
    use InteractsWithMedia;
    use LogsActivity;
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

    public function link(): CalendarLink
    {
        return new CalendarLink($this);
    }

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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
    }
}
