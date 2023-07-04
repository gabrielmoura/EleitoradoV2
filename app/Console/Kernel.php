<?php

namespace App\Console;

use App\Jobs\RemoveOldPuxada;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('backup:run --only-db')->daily()->at('3:00')->onOneServer();

        /** Limpar filas diariamente.  */
        $schedule->command('queue:prune-batches')->daily()->onOneServer();
        $schedule->command('queue:prune-failed')->daily()->onOneServer();

        /** Limpar tokens expirados todo mes */
        $schedule->command('sanctum:prune-expired')->monthly();

        /** Limpar SoftDeletes de ano em ano */
        //        $schedule->command('model:prune')->yearly();

        /** Métricas Trabalhos em fila */
        $schedule->command('horizon:snapshot')->everyFiveMinutes()
            ->environments(['production', 'staging']);
        $schedule->command('horizon:snapshot')->everyMinute()
            ->environments(['development', 'local']);

        /** Métricas de uso do sistema */

        /** Remove arquivos Temporários */
        $schedule->command('media-library:delete-old-temporary-uploads')->everyFiveMinutes()
            ->environments(['production', 'staging']);
        $schedule->command('media-library:delete-old-temporary-uploads')->everyMinute()
            ->environments(['development', 'local']);

        /** Remove arquivos de Puxada */
        $schedule->job(RemoveOldPuxada::class)->everyFiveMinutes()
            ->environments(['development', 'local']);
        $schedule->job(RemoveOldPuxada::class)->everyFourHours()
            ->environments(['production', 'staging']);

        /** Envio de Mensagem para aniversariantes */
        $schedule->command('send:birthday')->dailyAt('08:00')
            ->environments(['production', 'staging'])->onOneServer();

    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
