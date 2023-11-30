<?php

namespace App\Models;

use App\Actions\Tools\CompanyConfig;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Cashier\Billable;
use Laravel\Pennant\Concerns\HasFeatures;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Company extends Model implements HasMedia
{
    use Billable;
    use HasFactory;
    use HasFeatures;
    use InteractsWithMedia;
    use LogsActivity;
    use Notifiable;
    use SoftDeletes;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'meta' => 'collection',
        'conf' => 'collection',
        'tax_id_data' => 'array',
    ];

    protected $fillable = [
        'name',
        'address',
        'email',
        'phone',
        'website',
        'logo',
        'meta',
        'banned',
        //        'tenant_id',
        'tax_id_data',
    ];

    protected $hidden = [
        'conf',
    ];

    public function config(): CompanyConfig
    {
        return new CompanyConfig($this);
    }

    public function people(): HasMany
    {
        return $this->hasMany(Person::class, 'tenant_id', 'tenant_id');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'company_id', 'id');
    }

    public function groups(): HasMany
    {
        return $this->hasMany(Group::class, 'tenant_id', 'tenant_id');
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'tenant_id', 'tenant_id');
    }

    public function demands(): HasMany
    {
        return $this->hasMany(Demand::class, 'tenant_id', 'tenant_id');
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'tenant_id', 'tenant_id');
    }

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($model) {
            $model->tenant_id = Str::ulid()->toRfc4122();
        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
        // Chain fluent methods for configuration options
    }

    /**
     * @description Conversões de mídia
     * @param Media|null $media
     * @return void
     * @throws InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        /** Converte Imagem vinda de avatar para webP e reduz para 240x170 */
        $this->addMediaConversion('cover')
            ->performOnCollections('avatar')
            ->format(Manipulations::FORMAT_WEBP)
            ->width(240)->height(170)
            ->quality(80)
            ->queued();
    }
}
