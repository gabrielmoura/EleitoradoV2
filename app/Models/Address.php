<?php

namespace App\Models;

use App\Service\Trait\HasTenant;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Address extends Model
{
    use HasFactory;
    use LogsActivity;
    use HasTenant;

    protected $fillable = [
        'street',
        'number',
        'complement',
        'district',
        'city',
        'state',
        'country',
        'zipcode',
        'reference',
        'latitude',
        'longitude',
        'tenant_id',
        'uf',
        'district',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function full_address(): Attribute
    {
        return Attribute::get(function () {
            return "{$this->street}, {$this->number} - {$this->district}, {$this->city} - {$this->uf}";
        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
        // Chain fluent methods for configuration options
    }
}
