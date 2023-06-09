<?php

namespace App\ServiceHttp\UTalk\Endpoints;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Collection;

class Chat extends UtalkBase
{
    public function get(string $idChat, string $organizationId): Collection
    {
        $req = $this->service
            ->refreshToken()
            ->get("/chats/$idChat/", [
                'organizationId' => $organizationId,
                'includeMessages' => 0,
            ]);
        $req->onError(function (RequestException $e) {
            throw new UtalkException($e->response->json() ?? 'HTTP request returned status code '.$e->response->status(), $e->response->status());
        });

        return $this->transform(
            $req->json(),
            Chat::class
        );
    }

    public function closeSession(string $idChat, string $organizationId, string $channelId, string $memberId, string $sectorId): Collection
    {
        $req = $this->service
            ->refreshToken()
            ->put("/chats/$idChat/", [
                'organizationId' => $organizationId,
                'includeMessages' => 0,
                'open' => false,
                'private' => true,
                'mute' => true,
                'channelId' => $channelId,
                'memberId' => $memberId,
                'sectorId' => $sectorId,
            ]);
        $req->onError(function (RequestException $e) {
            throw new UtalkException($e->response->json() ?? 'HTTP request returned status code '.$e->response->status(), $e->response->status());
        });

        return $this->transform(
            $req->json(),
            Chat::class
        );
    }
}
