<?php

namespace Sfneal\Honeypot\Models;

use Database\Factories\TrackSpamFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sfneal\Models\Model;
use Sfneal\Scopes\CreatedOrderScope;
use Sfneal\Tracking\Models\TrackTraffic;

class TrackSpam extends Model
{
    use HasFactory;

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
     * Create a new factory instance for the model.
     *
     * @return TrackSpamFactory
     */
    protected static function newFactory(): TrackSpamFactory
    {
        return new TrackSpamFactory();
    }

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
