<?php

namespace App\Providers;

use App\Mail\JobFailedMailable;
use App\Models\Company;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Lottery;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;
use Laravel\Pennant\Feature;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            //            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Cashier::useCustomerModel(Company::class);
        Queue::failing(function (JobFailed $event) {
            Mail::to(config('mail.to.address'))->queue(new JobFailedMailable($event));
        });

        Feature::define('site-redesign', Lottery::odds(10, 100));

        /**
         * @description Implementa o whereLike no Eloquent Builder
         *
         * @param  string|array  $attributes
         * @param  string|null  $searchTerm
         * @return Builder
         */
        Builder::macro('whereLike', function (string|array $attributes, ?string $searchTerm) {
            //@phpstan-ignore-next-line
            $this->where(function (Builder $query) use ($attributes, $searchTerm) {
                foreach (Arr::wrap($attributes) as $attribute) {
                    $query->when(str_contains($attribute, '.'),
                        function (Builder $query) use ($attribute, $searchTerm) {
                            [$relationName, $relationAttribute] = explode('.', $attribute);
                            $query->orWhereHas($relationName, function (Builder $query) use ($relationAttribute, $searchTerm) {
                                $query->where($relationAttribute, 'LIKE', "%{$searchTerm}%");
                            });
                        },
                        function (Builder $query) use ($attribute, $searchTerm) {
                            $query->orWhere($attribute, 'LIKE', "%{$searchTerm}%");
                        }
                    );
                }
            });

            return $this;
        });

        /**
         * @description Implementa o whenLike no Eloquent Builder
         *
         * @param  string|null  $condition
         * @param  string  $attribute
         * @return Builder
         */
        Builder::macro('whenLike', function (?string $condition, string $attribute) {
            //@phpstan-ignore-next-line
            $this->where(function (Builder $query) use ($condition, $attribute) {
                $query->when($condition, function (Builder $query) use ($attribute, $condition) {
                    $query->when(str_contains($attribute, '.'), function (Builder $query) use ($attribute, $condition) {
                        [$relationName, $relationAttribute] = explode('.', $attribute);
                        $query->orWhereHas($relationName, function (Builder $query) use ($relationAttribute, $condition) {
                            $query->where($relationAttribute, 'LIKE', "%{$condition}%");
                        });
                    }, function (Builder $query) use ($attribute, $condition) {
                        $query->orWhere($attribute, 'LIKE', "%{$condition}%");
                    });
                });
            });

            return $this;
        });
    }
}
