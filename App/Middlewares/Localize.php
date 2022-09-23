<?php

namespace App\Middlewares;

class Localize
{
    public function handle(Request $request)
    {
        // if (!in_array($request->locale, config('app.supported_locales'))) {
        //    $base = url()->to('');
        //    $path = str_replace($base, '', $request->fullUrl());

        //    return redirect()->to($base . '/' . config('app.locale') . $path);
        // }

        // app()->setLocale($request->locale);

        // URL::defaults(['locale' => $request->locale]);

        // return $next($request);

        return $request;
    }
}