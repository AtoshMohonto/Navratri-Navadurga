<?php

namespace App\Core;

interface Middleware
{
    /**
     * Return false to stop the request (the middleware is responsible for
     * sending a response, e.g. a redirect or abort, before returning false).
     */
    public function handle(Request $request): bool;
}
