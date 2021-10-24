<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMaintenanceEventTypeRequest;
use App\Http\Requests\UpdateMaintenanceEventTypeRequest;
use App\Http\Resources\Admin\MaintenanceEventTypeResource;
use App\Models\MaintenanceEventType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MaintenanceEventTypeApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('maintenance_event_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new MaintenanceEventTypeResource(MaintenanceEventType::all());
    }

    public function store(StoreMaintenanceEventTypeRequest $request)
    {
        $maintenanceEventType = MaintenanceEventType::create($request->all());

        return (new MaintenanceEventTypeResource($maintenanceEventType))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(MaintenanceEventType $maintenanceEventType)
    {
        abort_if(Gate::denies('maintenance_event_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new MaintenanceEventTypeResource($maintenanceEventType);
    }

    public function update(UpdateMaintenanceEventTypeRequest $request, MaintenanceEventType $maintenanceEventType)
    {
        $maintenanceEventType->update($request->all());

        return (new MaintenanceEventTypeResource($maintenanceEventType))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(MaintenanceEventType $maintenanceEventType)
    {
        abort_if(Gate::denies('maintenance_event_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $maintenanceEventType->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
