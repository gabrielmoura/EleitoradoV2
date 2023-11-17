<?php

namespace App\Exceptions;

use App\Models\User;
use DomainException;
use Throwable;

class TenantException extends DomainException
{
    public function __construct(string $message = '', int $code = 0, Throwable $previous = null, public ?User $user = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
