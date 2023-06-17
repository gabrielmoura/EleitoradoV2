<?php

namespace App\ServiceHttp\UTalk\Endpoints;

use App\ServiceHttp\UTalk\Entities\Member as MemberEntity;
use Illuminate\Http\Client\RequestException;

class Member extends UtalkBase
{
    public function getMe(): MemberEntity
    {
        $req = $this->service
            ->refreshToken()
            ->get('/members/me/');
        $req->onError(function (RequestException $e) {
            throw new UtalkException($e->getMessage(), $e->getCode());
        });

        return new MemberEntity($req->json());
    }
}
