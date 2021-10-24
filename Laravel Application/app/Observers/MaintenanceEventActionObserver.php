<?php

namespace App\Observers;

use App\Models\MaintenanceEvent;
use App\Notifications\DataChangeEmailNotification;
use Illuminate\Support\Facades\Notification;

class MaintenanceEventActionObserver
{
    public function created(MaintenanceEvent $model)
    {
        $data  = ['action' => 'created', 'model_name' => 'MaintenanceEvent'];
        $users = \App\Models\User::whereHas('roles', function ($q) { return $q->where('title', 'Admin'); })->get();
        Notification::send($users, new DataChangeEmailNotification($data));
    }
}
