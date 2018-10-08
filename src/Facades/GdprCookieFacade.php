<?php

namespace Atlanticmoon\GdprCookie\Facades;

use Illuminate\Support\Facades\Facade;
use Atlanticmoon\GdprCookie\Contracts\GdprCookie;

/**
 * @see \Atlanticmoon\GdprCookie\GdprCookie
 */
class GdprCookieFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
	    return GdprCookie::class;
    }
}
