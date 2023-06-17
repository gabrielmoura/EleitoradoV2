<?php

namespace App\ServiceHttp\UTalk\Endpoints;

use App\ServiceHttp\UTalk\Entities\Sector as SectorEntity;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Collection;

class Sector extends UtalkBase
{
    public function sectors(string $organizationId): Collection
    {
        $req = $this->service
            ->refreshToken()
            ->get('/sectors/', [
                'organizationId' => $organizationId,
            ]);
        $req->onError(function (RequestException $e) {
            throw new UtalkException($e->getMessage(), $e->getCode());
        });

        return $this->transform($req->json(),
            SectorEntity::class);
    }
}
