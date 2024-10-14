<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        '/fingerprint/callback',
        '/fingerprint/get-log',
        '/fingerprint/get-user',
        '/fingerprint/get-user-all',
        '/fingerprint/delete-user',
        '/fingerprint/set-timezone',
        '/fingerprint/restart',
    ];
}
