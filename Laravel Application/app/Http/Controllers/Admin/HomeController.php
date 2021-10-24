<?php

namespace App\Http\Controllers\Admin;

use App\Models\MaintenanceEvent;
use App\Models\Point;
use App\Models\Thing;
use App\Models\User;

class HomeController
{
    public function index()
    {

        $pois = Point::with(['sensors','poiMaintenanceEvents'])->get();
        $mEvents = MaintenanceEvent::noPoi()->get();
        $totalThings = Thing::all()->count();
        $totalUsers = User::all()->count();
        $totalPois = count($pois);
        $totalmEvents = count($mEvents);

        return view('home',compact('pois','mEvents','totalThings','totalUsers','totalPois','totalmEvents'));
    }
}
