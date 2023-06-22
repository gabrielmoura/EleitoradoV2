<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Cashier\Billable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Company extends Model implements HasMedia
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;
    use Notifiable;
    use InteractsWithMedia;
    use Billable;

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
        'conf',
        'banned',
        //        'tenant_id',
        'tax_id_data',
    ];

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
     * Conversões de mídia
     *
     * @throws InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        /** Converte Imagem vinda de avatar para webP e reduz para 100x100 */
        $this->addMediaConversion('cover')
            ->performOnCollections('avatar')
            ->format(Manipulations::FORMAT_WEBP)
            ->width(100)->height(100)
            ->quality(80)
            ->queued();
    }
}
