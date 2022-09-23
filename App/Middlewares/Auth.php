<?php
namespace App\Middlewares;
use Session;
class Auth
{

    public static function handle()
    {
        if (!Session::has('swLogin'))
        {
            redirect(link_to('login'));
        }
    }

}