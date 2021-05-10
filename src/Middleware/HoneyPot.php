<?php

namespace Sfneal\Honeypot\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Honeypot\ProtectAgainstSpam;
use Symfony\Component\HttpFoundation\Response;

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
        if ($this->requestHasTraps($request)) {
            return $this->respondToSpam($request, $next);
        }

        // Pass request to parent `ProtectAgainstSpam` handler
        return parent::handle($request, $next);
    }

    /**
     * Determine if a Request contains Honeypot traps.
     *
     * @param Request $request
     * @return bool
     */
    private function requestHasTraps(Request $request): bool
    {
        // Execute check if 'duplicate names' trap is enabled
        if (config('honeypot.traps.duplicate_names.enabled')) {
            $first = config('honeypot.traps.duplicate_names.name_first_input');
            $last = config('honeypot.traps.duplicate_names.name_last_input');

            // Determine if the 'first' & 'last' name inputs are the same
            return $request->has($first)
                && $request->has($last)
                && $request->input($first) == $request->input($last);
        }

        // Return false if traps are not enabled
        return false;
    }
}
