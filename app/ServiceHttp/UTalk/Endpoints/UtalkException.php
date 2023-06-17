<?php

namespace App\ServiceHttp\UTalk\Endpoints;

use DomainException;
use Illuminate\Support\Facades\Log;

class UtalkException extends DomainException
{
    public function __construct($message, $code = 0, \Exception $previous = null)
    {
        $message = 'UTalk: ' . $message;
        parent::__construct($message, $code, $previous);
    }

    // report
    public function report(): void
    {
        Log::error($this->getMessage());
    }
}
