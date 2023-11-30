<?php

namespace App\Models;

use App\Service\Trait\ChartScopeTrait;
use App\Service\Trait\HasPid;
use App\Service\Trait\HasTenant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Vite;
use Laravel\Scout\Searchable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\Uid\Ulid;

class Person extends Model implements HasMedia
{
    use ChartScopeTrait;
    use HasFactory;
    use HasPid;
    use HasTenant;
    use InteractsWithMedia;
    use LogsActivity;
    use Searchable;
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
        'dateOfBirthIncludeYear' => 'boolean',
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

    public function demands(): BelongsToMany
    {
        return $this->belongsToMany(Demand::class, 'demand_people', 'person_id', 'demand_id');
    }

    public function getImageAttribute(): ?string
    {
        return $this->getFirstMedia('avatar')?->getUrl('cover') ?? Vite::asset("resources/images/$this->sex.png");
    }

    protected function telephone(): Attribute
    {
        return Attribute::make(
            get: function (?string $value) {
                if ($value !== null && strlen($value) === 8) {
                    return $value = '5521'.$value;
                } elseif ($value !== null && strlen($value) === 10) {
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
                if ($value !== null && strlen($value) === 9) {
                    return $value = '5521'.$value;
                } elseif ($value !== null && strlen($value) === 11) {
                    return $value = '55'.$value;
                } else {
                    return $value;
                }
            },
            //            set: fn (string $value) => $value,
        );
    }

    public function scopeFindPid(Builder $query, string $pid): Builder
    {
        return $query->where('pid', Ulid::fromString($pid)->toRfc4122());
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
        // Chain fluent methods for configuration options
    }

    /**
     * Conversões de mídia
     *
     * @throws InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        /** Converte Imagem vinda de avatar para webP e reduz para 230x280 */
        $this->addMediaConversion('cover')
            ->performOnCollections('avatar')
            ->format(Manipulations::FORMAT_WEBP)
            ->width(230)->height(280)
            ->quality(80)
            ->queued();
    }

    /**
     * @url https://laravel.com/docs/10.x/scout#modifying-the-import-query
     */
    protected function makeAllSearchableUsing(Builder $query): Builder
    {
        return $query->with('address');
    }

    /**
     * @url https://laravel.com/docs/10.x/scout#configuring-searchable-data
     */
    public function toSearchableArray(): array
    {
        $array = $this->toArray();
        $array['address'] = $this->address?->toArray();

        return $array;
    }
}
