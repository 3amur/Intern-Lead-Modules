<?php

namespace Modules\PotentialCustomer\app\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use Nwidart\Modules\Routing\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Modules\PotentialCustomer\app\Models\Link;
use Modules\PotentialCustomer\app\Models\LeadAccount;
use Modules\PotentialCustomer\app\Http\Requests\LinkRequest;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort(404);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LinkRequest $request)
    {
        $potentialAccount = LeadAccount::select('id', 'account_name', 'lead_account_title')
            ->where('id', $request->potential_account_id)
            ->where('status', 'active')
            ->where('condition', 'potential')
            ->first();


        if ($potentialAccount) {
            $route = Route::getRoutes()->getByName('collected_customer_data.form_page');
            if ($route) {
                $uri = $route->uri;
                $link = Link::create([
                    'subject' => $request->subject,
                    'expired_at' => Carbon::parse($request->expired_at)->format('Y-m-d H:i:s'),
                    'url' => url($uri),
                    'account_id' => $potentialAccount->id,
                    'created_by' => auth()->id(),
                ]);

                $params = [
                    "customer_name" => str_replace(' ', '_', $potentialAccount->account_name),
                    'customer_id' => $potentialAccount->id,
                    "has_family" => $request->has_family == 'on' ? true : false,
                    "wife_husband" => $request->wife_husband == 'on' ? true : false,
                    "has_parent" => $request->has_parent == 'on' ? true : false,
                    "has_children" => $request->has_children == 'on' ? true : false,
                    "children_count" => $request->children_count == null ? 0 : $request->children_count,
                    'link' => $link->id,
                ];
                $queryString = http_build_query($params);

                $link->update([
                    'url' => $link->url . '?' . $queryString,
                ]);

                Alert::success(__('Link Created Successfully:'), $link->url);
                return redirect()->back();
            }

        } else {
            Alert::error(__('Invalid Potential Customer'));
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Link $link)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Link $link)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LinkRequest $request, Link $link)
    {
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Link $link)
    {
        $link->update(['deleted_by' => auth()->id()]);
        $link->delete();
        Alert::success(__('Success'), __('Link Deleted Successfully'));

    }

}
