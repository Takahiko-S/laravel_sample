<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
  /*   protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    } */
    protected function redirectTo(Request $request){
        if(! $request->expectsJson()){
            $url = $request->path();
            
            if(Str::startsWith($url,['admins'])){
                return 'admin_login';
            }
            return route('login');
        }
    }
}
