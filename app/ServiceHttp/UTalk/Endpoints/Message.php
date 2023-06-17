<?php

namespace App\ServiceHttp\UTalk\Endpoints;

use App\ServiceHttp\UTalk\Entities\Message as MessageEntity;
use Illuminate\Http\Client\RequestException;

class Message extends UtalkBase
{
    public function set(string $toPhone, string $fromPhone, string $organizationId, string $message, string|null $file = null, bool $skipReassign = false): MessageEntity
    {
        $req = $this->service
            ->refreshToken()
            ->post('/messages/simplified/', [
                'toPhone' => $toPhone,
                'fromPhone' => $fromPhone,
                'organizationId' => $organizationId,
                'message' => $message,
                'file' => $file,
                'skipReassign' => $skipReassign,
            ]);
        $req->onError(function (RequestException $e) {
            throw new UtalkException($e->getMessage(), $e->getCode());
        });

        return new MessageEntity($req->json());
    }

    public function get(string $messageId, string $organizationId): MessageEntity
    {
        $req = $this->service
            ->refreshToken()
            ->post("/messages/$messageId/", [
                'organizationId' => $organizationId,
            ]);
        $req->onError(function (RequestException $e) {
            throw new UtalkException($e->getMessage(), $e->getCode());
        });

        return new MessageEntity($req->json());
    }
}