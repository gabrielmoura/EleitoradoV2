<?php

namespace App\ServiceHttp\UTalk\Endpoints;

use App\ServiceHttp\UTalk\Entities\Channel as ChannelEntity;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Collection;

class Channel extends UtalkBase
{
    public function channels(string $organizationId): Collection
    {
        $req = $this->service
            ->refreshToken()
            ->get('/channels/', [
                'organizationId' => $organizationId,
            ]);
        $req->onError(function (RequestException $e) {
            throw new UtalkException($e->getMessage(), $e->getCode());
        });

        return $this->transform($req->json(),
            ChannelEntity::class);
    }
}
