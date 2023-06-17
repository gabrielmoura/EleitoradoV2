<?php

namespace App\ServiceHttp\UTalk;

use App\ServiceHttp\UTalk\Endpoints\HasChannel;
use App\ServiceHttp\UTalk\Endpoints\HasChat;
use App\ServiceHttp\UTalk\Endpoints\HasMember;
use App\ServiceHttp\UTalk\Endpoints\HasMessage;
use App\ServiceHttp\UTalk\Endpoints\HasSector;
use App\ServiceHttp\UTalk\Endpoints\HasWebhook;
use App\ServiceHttp\UTalk\Endpoints\UtalkException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

/**
 * Class UtalkService
 *
 * @property PendingRequest $api
 * @property string $version
 *
 * @description This class is a service to connect with UTalk API
 *
 * @url https://app-utalk.umbler.com/api/v1/
 * @url https://app-utalk.umbler.com/api/docs/index.html
 *
 * @method PendingRequest withToken(string $token)
 */
class UtalkService
{
    use HasChat;
    use HasMessage;
    use HasMember;
    use HasChannel;
    use HasSector;
    use HasWebhook;

    public PendingRequest $api;

    protected string $version = 'v1';

    public function __construct()
    {
        $this->api = Http::baseUrl("https://app-utalk.umbler.com/api/$this->version/")
            ->acceptJson()
            ->contentType('application/json');
    }

    public function refreshToken(): PendingRequest
    {
        if (config('services.utalk.key') === null) {
            throw new UtalkException('API Key is not defined');
        }
        $this->api->withToken(config('services.utalk.key'));

        return $this->api;
    }
}
