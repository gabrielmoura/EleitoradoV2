<?php

namespace App\Models;

use App\Events\Dash\Campaign\CampaignCreatedEvent;
use App\Service\Trait\HasPid;
use App\Service\Trait\HasTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Campaign extends Model implements HasMedia
{
    use HasFactory;
    use HasPid;
    use HasTenant;
    use InteractsWithMedia;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'message',
        'status',
        'url',
        'direct_mail_id',

        'to_id',
        'to_type',
        'channel',
        'meta',
        'batch_id',
        'pid',
    ];

    protected $casts = [
        'meta' => 'array',
        //        'batch_id' => 'uuid',
        //        'pid' => 'uuid',
    ];

    protected $dispatchesEvents = [
        'created' => CampaignCreatedEvent::class,
        //        'updated' => CampaignUpdatedEvent::class,
        //        'deleted' => CampaignDeletedEvent::class,
    ];
}
