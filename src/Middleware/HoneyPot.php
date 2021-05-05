<?php

namespace Sfneal\Honeypot\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Honeypot\ProtectAgainstSpam;
use Symfony\Component\HttpFoundation\Response;

// todo: add tests
class HoneyPot extends ProtectAgainstSpam
{
    /**
     * Check if 'first' & 'last' name inputs are the same.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if first & last name inputs are the same (typical of spam)
        // todo: add ability to change keys in config and/or with constructor
        // todo: add use of config!
        if (
            $request->has('data.name_first')
            && $request->has('data.name_last')
            && $request->input('data.name_first') == $request->input('data.name_last')
        ) {
            return $this->respondToSpam($request, $next);
        }

        return parent::handle($request, $next);
    }
}
