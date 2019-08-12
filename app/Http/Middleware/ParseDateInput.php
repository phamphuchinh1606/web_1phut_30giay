<?php

namespace App\Http\Middleware;

use App\Helpers\DateTimeHelper;
use Closure;
use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;
use Illuminate\Support\Str;

class ParseDateInput extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        foreach ($request->all() as $key => $value){
            if(Str::contains($key,['date','_date','Date'])){
                $request[$key] = DateTimeHelper::dateFromString($value);
            }
        }
        return $next($request);
    }
}
