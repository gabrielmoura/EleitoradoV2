<?php

namespace App\Models;

use App\Events\Dash\DirectMail\DirectMailCreatedEvent;
use App\Service\Trait\HasPid;
use App\Service\Trait\HasTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DirectMail extends Model
{
    use HasFactory;
    use HasPid;
    use HasTenant;

    protected $fillable = [
        'person_id',
        'tenant_id',
        'received',
        'want_to_receive',
        'vote',
        'know_a_proposal',
        'indicate',
    ];

    protected $casts = [
        'received' => 'collection',
        'want_to_receive' => 'collection',
        'vote' => 'boolean',
        'know_a_proposal' => 'boolean',
        'indicate' => 'integer',
    ];

    protected $dispatchesEvents = [
        'created' => DirectMailCreatedEvent::class,
    ];
}
