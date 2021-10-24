<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyMaintenanceEventTypeRequest;
use App\Http\Requests\StoreMaintenanceEventTypeRequest;
use App\Http\Requests\UpdateMaintenanceEventTypeRequest;
use App\Models\MaintenanceEventType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class MaintenanceEventTypeController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('maintenance_event_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = MaintenanceEventType::query()->select(sprintf('%s.*', (new MaintenanceEventType())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'maintenance_event_type_show';
                $editGate = 'maintenance_event_type_edit';
                $deleteGate = 'maintenance_event_type_delete';
                $crudRoutePart = 'maintenance-event-types';

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
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.maintenanceEventTypes.index');
    }

    public function create()
    {
        abort_if(Gate::denies('maintenance_event_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.maintenanceEventTypes.create');
    }

    public function store(StoreMaintenanceEventTypeRequest $request)
    {
        $maintenanceEventType = MaintenanceEventType::create($request->all());

        return redirect()->route('admin.maintenance-event-types.index');
    }

    public function edit(MaintenanceEventType $maintenanceEventType)
    {
        abort_if(Gate::denies('maintenance_event_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.maintenanceEventTypes.edit', compact('maintenanceEventType'));
    }

    public function update(UpdateMaintenanceEventTypeRequest $request, MaintenanceEventType $maintenanceEventType)
    {
        $maintenanceEventType->update($request->all());

        return redirect()->route('admin.maintenance-event-types.index');
    }

    public function show(MaintenanceEventType $maintenanceEventType)
    {
        abort_if(Gate::denies('maintenance_event_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.maintenanceEventTypes.show', compact('maintenanceEventType'));
    }

    public function destroy(MaintenanceEventType $maintenanceEventType)
    {
        abort_if(Gate::denies('maintenance_event_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $maintenanceEventType->delete();

        return back();
    }

    public function massDestroy(MassDestroyMaintenanceEventTypeRequest $request)
    {
        MaintenanceEventType::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
