<?php

namespace App\Http\Livewire;

use App\Models\Company;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class AlertsCenter extends Component
{
    public $notifications;

    public function mount(): void
    {
        $company = Company::find(session()->get('company.id'));
        $this->notifications = $company->unreadNotifications->sortByDesc('created_at')->filter(function ($notification) {
            return $notification->type === 'App\Notifications\System\GenericNotification';
        });
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.alerts-center', [
            'notifications' => $this->notifications,
        ]);
    }
}
