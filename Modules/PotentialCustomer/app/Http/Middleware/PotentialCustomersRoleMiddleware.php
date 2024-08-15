<?php

namespace Modules\PotentialCustomer\app\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;
use app\Helpers\Helpers;

class PotentialCustomersRoleMiddleware
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
                $this->getRoute() == 'collected_customer_data.storeFamilyData'
                || $this->getRoute() == 'cities.getCities'
                || $this->getRoute() == 'states.getStates'
                || $this->getRoute() == 'sales_targets.checkExistingTargetOnCreate'
                || $this->getRoute() == 'sales_targets.checkExistingTargetOnUpdate'

                || ($page == "import") && Helpers::perUser($type . ".import")
                || ($page == "matchColumns") && Helpers::perUser($type . ".import")
                || ($page == "matchColumnUpdate") && Helpers::perUser($type . ".import")
                || ($page == "getImportedData") && Helpers::perUser($type . ".import")
                || ($page == "updateDuplicate") && Helpers::perUser($type . ".import")
                || ($page == "updateSelectedDuplicate") && Helpers::perUser($type . ".import")
                || ($page == "updateWithSomeChanges") && Helpers::perUser($type . ".import")
                || ($page == "insertNewData") && Helpers::perUser($type . ".import")
                || ($page == "exportInvalidRows") && Helpers::perUser($type . ".import")
                || ($page == "exportFullDuplicate") && Helpers::perUser($type . ".import")
                || ($page == "exportWithSomeChanges") && Helpers::perUser($type . ".import")
                || ($page == "exportNewData") && Helpers::perUser($type . ".import")
                || ($page == "exportSelectedMembers") && Helpers::perUser($type . ".export")
                || ($page == "exportCollectedData") && Helpers::perUser($type . ".export")
                || ($page == "export") && Helpers::perUser($type . ".export")
                || ($page == "changeSelectedRows") && Helpers::perUser($type . ".edit")
                || ($page == 'getIds' && Helpers::perUser($type . '.index'))

                || ($page == "activate") && Helpers::perUser($type . ".edit")


                || $this->getRoute() == 'sales_targets.getTargetLayersData'
                || Helpers::perUser($this->getRoute())
                || ($page == 'multi_destroy' && Helpers::perUser($type . '.destroy'))
                || ($page == 'store' && Helpers::perUser($type . '.create'))
                || ($page == 'update' && Helpers::perUser($type . '.edit'))
                || ($page == 'change_status' && Helpers::perUser($type . '.edit'))
                || in_array($this->getRoute(), ['dashboard', 'users.profile', 'users.profile_update'])
            ) {
                return $next($request);
            } else {
                return abort(403);
            }
        }
        return redirect()->route('redirect');
    }
}
