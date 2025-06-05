<?php

namespace Henriknordstrom\LaravelPdoOdbcPatched\Contracts;

use Closure;

interface OdbcDriver
{
    public static function registerDriver(): Closure;
}
