<?php

namespace App\ServiceHttp\UTalk\Endpoints;

use App\ServiceHttp\UTalk\Entities\Chat as ChatEntity;
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
            ChatEntity::class
        );
    }

    public function closeSession(string $idChat, string $organizationId, string $channelId, string $memberId, string $sectorId): ChatEntity
    {
        $req = $this->service
            ->refreshToken()
            ->put("/chats/$idChat/?organizationId=$organizationId", [
                //                'includeMessages' => 0,
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

        return new ChatEntity($req->json());
    }

    /**
     * @description Busca os chats começados pelo cliente e que não foram lidos
     */
    public function getUnread(string $idChat, string $organizationId): Collection
    {
        $req = $this->service
            ->refreshToken()
            ->get('/chats/', [
                'organizationId' => $organizationId,
                'ChatState' => 'Open',
                'LastMessage' => 'Contact',
                'Order' => 'Desc',
                'Skip' => 0,
                'Take' => 50,
                'Behavior' => 'GetSliceOnly',
            ]);
        $req->onError(function (RequestException $e) {
            throw new UtalkException($e->response->json() ?? 'HTTP request returned status code '.$e->response->status(), $e->response->status());
        });

        return $this->transform(
            $req->json('items'),
            ChatEntity::class
        );
    }
}
