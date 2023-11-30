<?php

namespace App\Jobs\Tools;

use App\Actions\Tools\GeoCoding\GeoCoding;
use App\Models\Address;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class UpdateAddressesJob implements ShouldBeUnique, ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $addresses = Address::whereNull('processed_at')->get();

        foreach ($addresses as $address) {
            // Caso o endereço não tenha sido processado e tenha rua, bairro, cidade e estado
            if ($address->zipcode === null && $address->street !== null) {
                $geo = new GeoCoding();
                try {
                    $data = $geo->getCached(
                        street: $address->street,
                        district: $address->district,
                        city: $address->city,
                        state: $address->state,
                        country: 'BR',
                        postal_code: null
                    )->first();

                    $address->latitude = $data->lat;
                    $address->longitude = $data->lon;
                    $address->processed_at = now();
                    $address->save();
                } catch (Throwable $throwable) {
                    report($throwable);
                }

            }
        }
    }
}
