<?php

namespace Modules\PotentialCustomer\app\Http\Controllers;

use Illuminate\Http\Request;
use Nwidart\Modules\Routing\Controller;
use Modules\PotentialCustomer\app\DataTables\CountryDataTable;

class HomeController extends Controller
{
    public function index()
    {
        return view('potentialcustomer::pages.home');
    }


}
