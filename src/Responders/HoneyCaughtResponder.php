<?php

namespace Sfneal\Honeypot\Responders;

use Closure;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Sfneal\Honeypot\SpamResponder\SpamResponder;
use Sfneal\Honeypot\Actions\TrackSpamAction;

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
        return response("If you're a robot, you've been caught by a human.  If you're a human, another human has mistaken you for a robot.");
    }
}
