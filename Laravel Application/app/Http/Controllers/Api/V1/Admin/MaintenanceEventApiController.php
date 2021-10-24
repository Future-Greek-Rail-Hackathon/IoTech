<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreMaintenanceEventRequest;
use App\Http\Requests\UpdateMaintenanceEventRequest;
use App\Http\Resources\Admin\MaintenanceEventResource;
use App\Models\MaintenanceEvent;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MaintenanceEventApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('maintenance_event_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new MaintenanceEventResource(MaintenanceEvent::with(['type', 'poi', 'assigned_to'])->get());
    }

    public function store(StoreMaintenanceEventRequest $request)
    {
        $maintenanceEvent = MaintenanceEvent::create($request->all());

        foreach ($request->input('images', []) as $file) {
            $maintenanceEvent->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('images');
        }

        foreach ($request->input('attachments', []) as $file) {
            $maintenanceEvent->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('attachments');
        }

        return (new MaintenanceEventResource($maintenanceEvent))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(MaintenanceEvent $maintenanceEvent)
    {
        abort_if(Gate::denies('maintenance_event_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new MaintenanceEventResource($maintenanceEvent->load(['type', 'poi', 'assigned_to']));
    }

    public function update(UpdateMaintenanceEventRequest $request, MaintenanceEvent $maintenanceEvent)
    {
        $maintenanceEvent->update($request->all());

        if (count($maintenanceEvent->images) > 0) {
            foreach ($maintenanceEvent->images as $media) {
                if (!in_array($media->file_name, $request->input('images', []))) {
                    $media->delete();
                }
            }
        }
        $media = $maintenanceEvent->images->pluck('file_name')->toArray();
        foreach ($request->input('images', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $maintenanceEvent->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('images');
            }
        }

        if (count($maintenanceEvent->attachments) > 0) {
            foreach ($maintenanceEvent->attachments as $media) {
                if (!in_array($media->file_name, $request->input('attachments', []))) {
                    $media->delete();
                }
            }
        }
        $media = $maintenanceEvent->attachments->pluck('file_name')->toArray();
        foreach ($request->input('attachments', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $maintenanceEvent->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('attachments');
            }
        }

        return (new MaintenanceEventResource($maintenanceEvent))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(MaintenanceEvent $maintenanceEvent)
    {
        abort_if(Gate::denies('maintenance_event_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $maintenanceEvent->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
