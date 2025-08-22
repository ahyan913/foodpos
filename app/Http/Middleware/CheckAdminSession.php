<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\AdminSession;
use Illuminate\Support\Facades\Auth;
use App\Models\Configuration;
use App\Helper\UrlHelper;

class CheckAdminSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        if(!Auth::check()){
            return redirect(UrlHelper::admin("login"));
        }

        view()->share("admin", Auth::user());

        $supportedLocale = Configuration::findByKey("locale_supported");
        $defaultLocale = Configuration::findByKey("locale_default");

        if(($key = array_search($defaultLocale, $supportedLocale)) !== false){
            unset($supportedLocale[$key]);
        }

        array_unshift($supportedLocale, $defaultLocale);
        view()->share("locale",$supportedLocale);
        view()->share("defaultLocale",$defaultLocale);


        return $next($request);
    }

}
