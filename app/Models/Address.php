<?php

namespace App\Models;

use App\Service\Trait\HasTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Address extends Model
{
    use HasFactory;
    use HasTenant;
    use LogsActivity;

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
        'processed_at',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'processed_at' => 'timestamp',
    ];

    public function getFullAddressAttribute(): string
    {
        return "{$this->street}, {$this->number} - {$this->district}, {$this->city} - {$this->uf}";
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
        // Chain fluent methods for configuration options
    }
}
