<?php

namespace Sfneal\Honeypot\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sfneal\Models\Model;
use Sfneal\Scopes\CreatedOrderScope;
use Sfneal\Tracking\Models\TrackTraffic;

// todo: add tests
class TrackSpam extends Model
{
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new CreatedOrderScope('desc'));
    }

    protected $connection = 'mysql';
    protected $table = 'track_spam';
    protected $primaryKey = 'track_spam_id';

    protected $fillable = [
        'track_spam_id',
        'request_token',
    ];

    /**
     * @var array Relationships that are always eager loaded
     */
    protected $with = [
        'tracking',
    ];

    /**
     * Related TrackTraffic data.
     *
     * @return BelongsTo
     */
    public function tracking()
    {
        return $this->belongsTo(TrackTraffic::class, 'request_token', 'request_token');
    }
}
