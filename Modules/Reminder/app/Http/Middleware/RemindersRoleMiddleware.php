<?php

namespace Modules\Reminder\app\Http\Middleware;
use Closure;
use app\Helpers\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class RemindersRoleMiddleware
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
                Helpers::perUser($this->getRoute())
                || ($page == 'multi_destroy' && Helpers::perUser($type . '.destroy'))
                || ($page == 'store' && Helpers::perUser($type . '.create'))
                || ($page == 'update' && Helpers::perUser($type . '.edit'))
                || ($page == 'updateDateWithDragAndDrop' && Helpers::perUser($type . '.edit'))
                || ($page == 'change_status' && Helpers::perUser($type . '.edit'))
                || ($page == 'updateRemindersOnCalendar' && Helpers::perUser($type . '.editRemindersOnCalendar'))
                || ($page == 'getIds' && Helpers::perUser($type . '.index'))
                || ($page == "export") && Helpers::perUser($type . ".export")


                || in_array($this->getRoute(), ['dashboard', 'users.profile', 'users.profile_update','reminders.home'])
            ) {
                return $next($request);
            } else {
                return abort(403);
            }
        }
        return redirect()->route('redirect');
    }
}
