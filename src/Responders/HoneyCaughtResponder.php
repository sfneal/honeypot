<?php

namespace Sfneal\Honeypot\Responders;

use Closure;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Sfneal\Honeypot\Actions\TrackSpamAction;
use Spatie\Honeypot\SpamResponder\SpamResponder;

class HoneyCaughtResponder implements SpamResponder
{
    /**
     * Provide an HTTP response to a spam request caught in the honeypot.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return ResponseFactory|Response
     */
    public function respond(Request $request, Closure $next)
    {
        // Track the Spam
        (new TrackSpamAction($request))->execute();

        // Return response
        return response(config('honeypot.response_content'));
    }
}
