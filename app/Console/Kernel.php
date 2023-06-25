<?php

namespace App\Console;

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
        $schedule->command('backup:run --only-db')->daily()->at('3:00');

        /** Limpar filas diariamente.  */
        $schedule->command('queue:prune-batches')->daily();
        $schedule->command('queue:prune-failed')->daily();

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
