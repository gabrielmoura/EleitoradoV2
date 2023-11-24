<?php

namespace App\Console\Commands\Tools;

use App\Models\Company;
use Illuminate\Console\Command;

class UsageStatistics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:usage-statistics';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Usage Statistics';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Usage statistics');

        $data = Company::cursor()->map(function (Company $company) {
            return [
                'company' => $company->name,
                'users' => $company->users()->count(),
                'people' => $company->people()->count(),
                'groups' => $company->groups()->count(),
                'appointments' => $company->appointments()->count(),
                'demands' => $company->demands()->count(),
                'events' => $company->events()->count(),

                'media' => formatBytes($company->getMedia('*')->map(function ($media) {
                    return $media->size;
                })->sum()),
            ];
        });

        $this->table(['Company', 'Users', 'People', 'Groups', 'Appointments', 'Demands', 'Events', 'Media'], $data);

    }
}
