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

    public Company $company;

    protected $listeners = ['refresh' => '$refresh', 'markAllAsRead' => 'markAllAsRead'];

    public function mount(): void
    {
        $this->company = auth()->user()->company;
        $this->notifications = $this->company->unreadNotifications
            ->sortByDesc('created_at')
            ->filter(fn ($notification) => $notification->type === 'App\Notifications\System\GenericNotification');
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.alerts-center', [
            'notifications' => $this->notifications,
        ]);
    }

    public function markAllAsRead(): void
    {
        $this->company->unreadNotifications->markAsRead();
        flash()->addSuccess(__('Todas as notificações foram marcadas como lidas.'));
        $this->emit('refresh');
    }

    public function markAsRead($notificationId): void
    {
        $this->company->unreadNotifications->where('id', $notificationId)->markAsRead();
        flash()->addSuccess(__('Notificação marcada como lida.'));
        $this->emit('refresh');
    }
}
