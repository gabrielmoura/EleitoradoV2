<?php

namespace App\Providers;

use App\Events\Dash\User\UserCreatedEvent;
use App\Events\Dash\User\UserUpdatedEvent;
use App\Events\Demand\DemandClosedEvent;
use App\Events\Demand\DemandCreatedEvent;
use App\Events\Export\PDF\ExportedPeopleAddress;
use App\Events\Export\PDF\ExportedTagEvent;
use App\Events\Export\PDF\FailedExportPeopleAddress;
use App\Events\Export\PDF\FailedExportTagEvent;
use App\Events\Export\PDF\RequestExportPeopleAddressEvent;
use App\Events\Export\PDF\RequestExportTagEvent;
use App\Events\System\GeneratedInviteEvent;
use App\Events\System\PlanCreated;
use App\Listeners\Dash\User\UserCreatedNotificationListener;
use App\Listeners\Dash\User\UserUpdatedClearPermissionCache;
use App\Listeners\Demand\DemandClosedMail;
use App\Listeners\Demand\DemandCreatedMail;
use App\Listeners\Export\PDF\ExportedPeopleAddressNotification;
use App\Listeners\Export\PDF\ExportedTagEventListener;
use App\Listeners\Export\PDF\ExportPeopleAddressListener;
use App\Listeners\Export\PDF\ExportTagEventListener;
use App\Listeners\Export\PDF\FailedExportedPeopleAddressNotification;
use App\Listeners\Export\PDF\FailedExportTagEventListener;
use App\Listeners\System\GeneratedInviteNotification;
use App\Listeners\System\PlanCreatedUpdateStripeListener;
use App\Listeners\System\StripeInvoiceMailerListener;
use App\Listeners\System\UpdateMediaInfoListener;
use App\Listeners\TestLaraDumps;
use Gabrielmoura\LaravelUtalk\Events\UtalkWebhookEvent;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Laravel\Cashier\Events\WebhookReceived;

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
        ExportedTagEvent::class => [
            ExportedTagEventListener::class,
        ],
        FailedExportTagEvent::class => [
            FailedExportTagEventListener::class,
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
        UserCreatedEvent::class => [
            UserCreatedNotificationListener::class,
        ],
        PlanCreated::class => [
            PlanCreatedUpdateStripeListener::class,
        ],
        UserUpdatedEvent::class => [
            UserUpdatedClearPermissionCache::class,
        ],
        WebhookReceived::class => [
            StripeInvoiceMailerListener::class,
        ],
        RequestExportPeopleAddressEvent::class => [
            ExportPeopleAddressListener::class,
        ],
        RequestExportTagEvent::class => [
            ExportTagEventListener::class,
        ],
        \Spatie\MediaLibrary\MediaCollections\Events\MediaHasBeenAdded::class => [
            UpdateMediaInfoListener::class,
        ],
        UtalkWebhookEvent::class => [
            TestLaraDumps::class,
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
