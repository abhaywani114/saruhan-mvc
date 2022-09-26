<?php

namespace App\Middlewares;

class Localize
{
    public static function handle($type)
    {
        route_access_type($type); 
    }
}