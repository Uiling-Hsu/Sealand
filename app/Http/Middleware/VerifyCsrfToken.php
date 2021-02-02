<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'newebpay_return',
        'newebpay_notify',
        'newebpay_return2',
        'newebpay_notify2',
        'newebpay_return3',
        'newebpay_notify3',
    ];
}
