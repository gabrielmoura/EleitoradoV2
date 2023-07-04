<?php

namespace App\Models;

use App\Actions\Tools\CalendarLink;
use App\Service\Trait\HasPid;
use App\Service\Trait\HasTenant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Symfony\Component\Uid\Ulid;

class Appointment extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasTenant;
    use HasPid;

    const RECURRENCE_RADIO = [
        'none' => 'Nenhum',
        'daily' => 'Diária',
        'weekly' => 'Semanalmente',
        'monthly' => 'Mensal',
    ];

    protected $fillable = [
        'name',
        'end_time',
        'event_id',
        'start_time',
        'recurrence',
        'created_at',
        'updated_at',
        'deleted_at',
        'description',
        'properties',
        'address_id',
        'appointment_id',
    ];

    protected $casts = [
        'properties' => 'collection',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function link(): CalendarLink
    {
        return new CalendarLink($this);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'appointment_id', 'id');
    }

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

    public function scopeFindPid(Builder $query, string $pid): Builder
    {
        return $query->where('pid', Ulid::fromString($pid)->toRfc4122());
    }
}
