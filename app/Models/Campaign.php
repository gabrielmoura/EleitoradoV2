<?php

namespace App\Models;

use App\Events\Dash\Campaign\CampaignCreatedEvent;
use App\Service\Trait\HasPid;
use App\Service\Trait\HasTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaign extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasTenant;
    use HasPid;

    protected $fillable = [
        'title',
        'description',
        'message',
        'status',
        'url',
        'attachment',
        'direct_mail_id',
    ];

    protected $dispatchesEvents = [
        'created' => CampaignCreatedEvent::class,
    ];
}
