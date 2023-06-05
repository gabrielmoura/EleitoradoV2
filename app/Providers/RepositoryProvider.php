<?php

namespace App\Providers;

use App\Repositories\AnalyticsRepository;
use App\Repositories\BatchRepository;
use App\Repositories\DemandRepository;
use App\Repositories\EloquentAnalyticsRepository;
use App\Repositories\EloquentBatchRepository;
use App\Repositories\EloquentDemandRepository;
use App\Repositories\EloquentPersonRepository;
use App\Repositories\PersonRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    public array $bindings = [
        PersonRepository::class => EloquentPersonRepository::class,
        BatchRepository::class => EloquentBatchRepository::class,
        AnalyticsRepository::class => EloquentAnalyticsRepository::class,
        DemandRepository::class => EloquentDemandRepository::class,
    ];
}
