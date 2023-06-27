<?php

namespace App\Console\Commands;

use App\Jobs\Send\SendWhatsapp;
use App\Models\Company;
use App\Models\Person;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;

class SendBirthday extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:birthday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia notificações para aniversariantes do dia.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Envio de notificações para aniversariantes do dia.');
        foreach (Company::whereBanned(false)->get() as $company) {
            $this->info("Empresa: {$company->name}");
            $people = $company->people()->whereDay('dateOfBirth', now()->day)->whereMonth('dateOfBirth', now()->month)->get();
            $this->info("Total de pessoas com celular e aniversário: {$people->whereNotNull('cellphone')->count()}");
            $this->info("Total de pessoas com email e aniversário: {$people->whereNotNull('email')->count()}");

            if ($people->count() === 0) {
                continue;
            }


            if ($company->config()->has('utalk.key')) {
                $batchWpp = Bus::batch([
                ]);
                $people->whereNotNull('cellphone')->each(fn(Person $person) => $batchWpp->add(new SendWhatsapp([
                    'phone' => $person->cellphone,
                    'message' => 'Feliz Aniversário'
                ], $company)));
                $batchWpp->dispatch();
            }

            $batchMail = Bus::batch([
            ]);
            $people->whereNotNull('email')->each(function (Person $person) use ($batchMail) {
//                $this->info("Enviando notificação para $person->name");
//
//                if ($person->email) {
//                    $batchMail->add(new SendMail($person));
//                }
            });
            $batchMail->dispatch();
        }


        $this->info('Envio de notificações finalizado com sucesso');
    }
}
