<?php

namespace App\ServiceHttp\UTalk\Endpoints;

use App\ServiceHttp\UTalk\Entities\Message;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Collection;

class SendMessage extends UtalkBase
{
    /**
     * @param  string|null  $file
     */
    public function set(string $toPhone, string $fromPhone, string $organizationId, string $message, string|null $file = null, bool $skipReassign = false): Collection
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

        return $this->transform(
            $req->json(),
            Message::class
        );
    }
}
