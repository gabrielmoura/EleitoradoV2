<?php

namespace App\Models;

use App\Models\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\Str;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\Uid\Ulid;

/**
 * App\Models\Person
 *
 * @property int $id
 * @property string $name
 * @property string|null $email
 * @property string|null $phone
 * @property string $cpf
 * @property string $rg
 * @property int|null $address_id
 * @property string|null $dateOfBirth
 * @property string|null $sex
 * @property string|null $meta
 * @property string $pid
 * @property int $tenant_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Address|null $address
 * @property-read Collection|Media[] $media
 * @property-read int|null $media_count
 * @property-read string $address_formatted
 * @property-read string $address_formatted_html
 * @property-read Collection|Event[] $events
 * @property-read int|null $events_count
 * @property-read Collection|Group[] $groups
 * @property-read int|null $groups_count
 * @method static Builder|Person findPid(string $pid)
 * @method static Builder|Person newModelQuery()
 * @method static Builder|Person newQuery()
 * @method static Builder|Person query()
 * @method static Builder|Person whereAddressId($value)
 * @method static Builder|Person whereCpf($value)
 * @method static Builder|Person whereCreatedAt($value)
 * @method static Builder|Person whereDateOfBirth($value)
 * @method static Builder|Person whereEmail($value)
 * @method static Builder|Person whereId($value)
 * @method static Builder|Person whereMeta($value)
 * @method static Builder|Person whereName($value)
 * @method static Builder|Person wherePhone($value)
 * @method static Builder|Person wherePid($value)
 * @method static Builder|Person whereRg($value)
 * @method static Builder|Person whereSex($value)
 * @method static Builder|Person whereTenantId($value)
 * @method static Builder|Person whereUpdatedAt($value)
 *
 */
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
    ];

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'group_people', 'person_id', 'group_id');
    }

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_people', 'person_id', 'event_id');
    }


    public function getImageAttribute(): ?string
    {
        return $this->getMedia('image')->first() ?? Vite::asset("resources/images/$this->sex.png");
    }

    public function getCellPhoneAttribute(): ?string
    {
        if (strlen($this?->cellphone) === 9) {
            return $this->attributes['cellphone'] = '5521' . $this->attributes['cellphone'];
        } elseif (strlen($this?->cellphone) === 11) {
            return $this->attributes['cellphone'] = '55' . $this->attributes['cellphone'];
        } else {
            return $this->attributes['cellphone'];
        }
    }

    public function getTelephoneAttribute(): ?string
    {
        if (strlen($this?->telephone) === 8) {
            return $this->attributes['telephone'] = '5521' . $this->attributes['telephone'];
        } elseif (strlen($this?->telephone) === 10) {
            return $this->attributes['telephone'] = '55' . $this->attributes['telephone'];
        } else {
            return $this->attributes['telephone'];
        }
    }

    protected function pid(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => Ulid::fromString($value),
            set: fn(Ulid|string $value) => $value instanceof Ulid ? $value->toRfc4122() : Ulid::fromString($value)->toRfc4122(),
        );
    }

    /**
     * @param Builder $query
     * @param string $pid
     * @return Builder
     */
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
            if (!app()->runningInConsole()) {
                $model->tenant_id = session()->get('tenant_id');
                $model->pid = Str::ulid()->toRfc4122();
            }
        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
        // Chain fluent methods for configuration options
    }
}
