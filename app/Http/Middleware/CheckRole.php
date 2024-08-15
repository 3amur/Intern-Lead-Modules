<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function getRoute()
    {
        return Route::current()->getName();
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $type = null;
            $page = null;
            if (str_contains($this->getRoute(), '.')) {
                list($type, $page) = explode('.', $this->getRoute());
            }
            if (
                $this->getRoute() == 'home.index' || Helpers::perUSer($this->getRoute()) || ($page == 'multi_destroy' && Helpers::perUSer($type . '.destroy'))
                || ($page == 'store' && Helpers::perUSer($type . '.create')) || ($page == 'export' && Helpers::perUSer($type . '.export'))  || ($page == 'update' && Helpers::perUSer($type . '.edit')) || ($page == 'change_status' && Helpers::perUSer($type . '.edit')) ||
                in_array($this->getRoute(), ['dashboard', 'users.profile', 'users.profile_update','dataTableSettings.store'])
            )
            {
                return $next($request);
            } else {
                return abort(403);
            }
        }
        return redirect()->route('redirect');
    }
}
