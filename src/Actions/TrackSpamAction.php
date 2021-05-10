<?php

namespace Sfneal\Honeypot\Actions;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Http\Request;
use Sfneal\Actions\Action;
use Sfneal\Honeypot\Models\TrackSpam;

class TrackSpamAction extends Action
{
    /**
     * @var string Unique TrackTraffic request_token
     */
    private $request_token;

    /**
     * TrackSpamAction constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request_token = $request->attributes->get('track_traffic_token');
    }

    /**
     * Execute the Action.
     *
     * @return Builder|EloquentModel|mixed
     */
    public function execute()
    {
        return TrackSpam::query()->create([
            'request_token' => $this->request_token,
        ]);
    }
}
