<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Plan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'plan_id',
        'name',
        'slug',
        'interval_count',
        'billing_method',
        'billing_period',
        'price', // in cents
        'price_decimal',
        'currency',
        'description',
        'metadata',
        'features',
    ];

    protected $casts = [
        'metadata' => 'collection',
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
        //        'price_decimal' => 'decimal:2',
        'price' => 'integer',
        'features' => 'collection',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected $dispatchesEvents = [
        'created' => \App\Events\System\PlanCreated::class,
        //        'updated' => \App\Events\System\PlanUpdated::class,
        //        'deleted' => \App\Events\System\PlanDeleted::class,
    ];

    protected function priceDecimal(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => $value ? number_format($value, 2, ',', '.') : null,
            set: fn (?string $value) => $this->attributes['price_decimal'] = $value ? str_replace(',', '.', $value) : null
        );
    }

    public function features(): Attribute
    {
        return Attribute::make(
            //            get: fn(?string $value) => $value ? json_decode($value, true) : null,
            set: fn (?string $value) => $this->attributes['features'] = $value ? json_encode(array_values(array_filter(explode(',', $value)))) : null
        );
    }

    protected static function boot(): void
    {
        parent::boot(); // TODO: Change the autogenerated stub
        static::creating(function ($model) {
            $model->slug = Str::slug($model->name);
        });
    }
}
