<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyMaintenanceEventRequest;
use App\Http\Requests\StoreMaintenanceEventRequest;
use App\Http\Requests\UpdateMaintenanceEventRequest;
use App\Models\MaintenanceEvent;
use App\Models\MaintenanceEventType;
use App\Models\Point;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class MaintenanceEventController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('maintenance_event_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = MaintenanceEvent::with(['type', 'poi', 'assigned_to'])->select(sprintf('%s.*', (new MaintenanceEvent())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'maintenance_event_show';
                $editGate = 'maintenance_event_edit';
                $deleteGate = 'maintenance_event_delete';
                $crudRoutePart = 'maintenance-events';

                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->addColumn('type_name', function ($row) {
                return $row->type ? $row->type->name : '';
            });

            $table->addColumn('poi_name', function ($row) {
                return $row->poi ? $row->poi->name : '';
            });

            $table->editColumn('status', function ($row) {
                return $row->status ? MaintenanceEvent::STATUS_SELECT[$row->status] : '';
            });
            $table->editColumn('images', function ($row) {
                if (!$row->images) {
                    return '';
                }
                $links = [];
                foreach ($row->images as $media) {
                    $links[] = '<a href="' . $media->getUrl() . '" target="_blank"><img src="' . $media->getUrl('thumb') . '" width="50px" height="50px"></a>';
                }

                return implode(' ', $links);
            });
            $table->editColumn('attachments', function ($row) {
                if (!$row->attachments) {
                    return '';
                }
                $links = [];
                foreach ($row->attachments as $media) {
                    $links[] = '<a href="' . $media->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>';
                }

                return implode(', ', $links);
            });
            $table->addColumn('assigned_to_name', function ($row) {
                return $row->assigned_to ? $row->assigned_to->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'type', 'poi', 'images', 'attachments', 'assigned_to']);

            return $table->make(true);
        }

        return view('admin.maintenanceEvents.index');
    }

    public function create()
    {
        abort_if(Gate::denies('maintenance_event_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $types = MaintenanceEventType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $pois = Point::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $assigned_tos = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.maintenanceEvents.create', compact('types', 'pois', 'assigned_tos'));
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

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $maintenanceEvent->id]);
        }

        return redirect()->route('admin.maintenance-events.index');
    }

    public function edit(MaintenanceEvent $maintenanceEvent)
    {
        abort_if(Gate::denies('maintenance_event_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $types = MaintenanceEventType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $pois = Point::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $assigned_tos = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $maintenanceEvent->load('type', 'poi', 'assigned_to');

        return view('admin.maintenanceEvents.edit', compact('types', 'pois', 'assigned_tos', 'maintenanceEvent'));
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

        return redirect()->route('admin.maintenance-events.index');
    }

    public function show(MaintenanceEvent $maintenanceEvent)
    {
        abort_if(Gate::denies('maintenance_event_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $maintenanceEvent->load('type', 'poi', 'assigned_to');

        return view('admin.maintenanceEvents.show', compact('maintenanceEvent'));
    }

    public function destroy(MaintenanceEvent $maintenanceEvent)
    {
        abort_if(Gate::denies('maintenance_event_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $maintenanceEvent->delete();

        return back();
    }

    public function massDestroy(MassDestroyMaintenanceEventRequest $request)
    {
        MaintenanceEvent::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('maintenance_event_create') && Gate::denies('maintenance_event_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new MaintenanceEvent();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
