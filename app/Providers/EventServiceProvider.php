<?php

namespace App\Providers;

use App\Events\Demand\DemandClosedEvent;
use App\Events\Demand\DemandCreatedEvent;
use App\Events\Export\PDF\ExportedPeopleAddress;
use App\Events\Export\PDF\FailedExportPeopleAddress;
use App\Events\System\GeneratedInviteEvent;
use App\Listeners\Demand\DemandClosedMail;
use App\Listeners\Demand\DemandCreatedMail;
use App\Listeners\Export\PDF\ExportedPeopleAddressNotification;
use App\Listeners\Export\PDF\FailedExportedPeopleAddressNotification;
use App\Listeners\System\GeneratedInviteNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ExportedPeopleAddress::class => [
            ExportedPeopleAddressNotification::class,
        ],
        FailedExportPeopleAddress::class => [
            FailedExportedPeopleAddressNotification::class,
        ],
        DemandCreatedEvent::class => [
            DemandCreatedMail::class,
        ],
        DemandClosedEvent::class => [
            DemandClosedMail::class,
        ],
        \Spatie\Backup\Events\BackupWasSuccessful::class => [
            // Backup Realizado com Sucesso
        ],
        \Spatie\Backup\Events\BackupHasFailed::class => [
            // Backup Falhou
        ],
        \Spatie\Backup\Events\CleanupWasSuccessful::class => [
            // Backup Limpo com Sucesso
        ],
        GeneratedInviteEvent::class => [
            GeneratedInviteNotification::class,
        ],

    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
