<?php

namespace App\Models;

use App\Models\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\Str;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Symfony\Component\Uid\Ulid;

class Person extends Model implements HasMedia
{
    use HasFactory;
    use LogsActivity;
    use InteractsWithMedia;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'tenant_id',
        'cpf',
        'rg',
        'address_id',
        'dateOfBirth',
        'sex',
        'meta',
        'pid',
        'cellphone',
        'telephone',
        'dateOfBirthIncludeYear',
        'voter_zone',
        'voter_section',
        'voter_registration',
        'email_verified_at',
        'phone_verified_at',
        'observation',
        'skinColor',
        'maritalStatus',
        'educationLevel',
        'occupation',
        'religion',
        'housing',
        'sexualOrientation',
        'genderIdentity',
        'deficiencyType',
    ];

    protected $casts = [
        'cpf' => 'string',
        'rg' => 'string',
        'dateOfBirth' => 'date',
        'meta' => 'collection',
        'sex' => 'string',
        'pid' => 'string',
        'phone_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'group_people', 'person_id', 'group_id')
            ->withPivot('checked_at', 'checked_by');
    }

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_people', 'person_id', 'event_id');
    }

    public function getImageAttribute(): ?string
    {
        return $this->getMedia('image')->first() ?? Vite::asset("resources/images/$this->sex.png");
    }

    protected function telephone(): Attribute
    {
        return Attribute::make(
            get: function (?string $value) {
                if (strlen($value) === 8) {
                    return $value = '5521'.$value;
                } elseif (strlen($value) === 10) {
                    return $value = '55'.$value;
                } else {
                    return $value;
                }
            },
            //            set: fn (string $value) => $value,
        );
    }

    protected function cellphone(): Attribute
    {
        return Attribute::make(
            get: function (?string $value) {
                if (strlen($value) === 9) {
                    return $value = '5521'.$value;
                } elseif (strlen($value) === 11) {
                    return $value = '55'.$value;
                } else {
                    return $value;
                }
            },
            //            set: fn (string $value) => $value,
        );
    }

//    protected function pid(): Attribute
//    {
//        return Attribute::make(
//            get: fn (string $value) => Ulid::fromString($value),
//            set: fn (Ulid|string $value) => $value instanceof Ulid ? $value->toRfc4122() : Ulid::fromString($value)->toRfc4122(),
//        );
//    }

    public function scopeFindPid(Builder $query, string $pid): Builder
    {
        return $query->where('pid', Ulid::fromString($pid)->toRfc4122());
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
                $model->pid = Str::ulid()->toRfc4122();
            }
        });
    }
    public function getRouteKeyName(): string
    {
        return 'pid';
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
        // Chain fluent methods for configuration options
    }
}
