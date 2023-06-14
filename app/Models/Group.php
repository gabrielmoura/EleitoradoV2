<?php

namespace App\Models;

use App\Models\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Symfony\Component\Uid\Ulid;

class Group extends Model
{
    use HasFactory;
    use LogsActivity;
    use Searchable;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'tenant_id',
        'pid',
    ];

    protected $casts = [
        //        'pid' => Ulid::class,
    ];

    protected function pid(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Ulid::fromString($value),
            //            set: fn(Ulid|string $value) => $value instanceof Ulid ? $value->toRfc4122() : Ulid::fromString($value)->toRfc4122(),
        );
    }

    public function persons(): BelongsToMany
    {
        return $this->belongsToMany(Person::class, 'group_people', 'group_id', 'person_id');
    }

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
        parent::boot(); // TODO: Change the autogenerated stub
        static::creating(function ($model) {
            if (! app()->runningInConsole()) {
                $model->tenant_id = session()->get('tenant_id');
                $model->pid = Str::ulid()->toRfc4122();
            }
        });
    }

//    protected function makeAllSearchableUsing(Builder $query): Builder
//    {
//        return $query->whitoutGlobalScope(TenantScope::class);
//    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
        // Chain fluent methods for configuration options
    }
}
