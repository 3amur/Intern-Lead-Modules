<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\PotentialCustomer\app\Models\Country;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.pages.home');
    }


    public function themeSetting()
    {
        return view('dashboard.pages.settings.theme-setting');
    }
    public function generalSetting()
    {
        return view('dashboard.pages.settings.general-setting');
    }
    public function moduleSetting()
    {
        return view('dashboard.pages.settings.module-setting');
    }
}
