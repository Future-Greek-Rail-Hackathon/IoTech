<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySensorTypeRequest;
use App\Http\Requests\StoreSensorTypeRequest;
use App\Http\Requests\UpdateSensorTypeRequest;
use App\Models\SensorType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SensorTypeController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('sensor_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = SensorType::query()->select(sprintf('%s.*', (new SensorType())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'sensor_type_show';
                $editGate = 'sensor_type_edit';
                $deleteGate = 'sensor_type_delete';
                $crudRoutePart = 'sensor-types';

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

        return view('admin.sensorTypes.index');
    }

    public function create()
    {
        abort_if(Gate::denies('sensor_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.sensorTypes.create');
    }

    public function store(StoreSensorTypeRequest $request)
    {
        $sensorType = SensorType::create($request->all());

        return redirect()->route('admin.sensor-types.index');
    }

    public function edit(SensorType $sensorType)
    {
        abort_if(Gate::denies('sensor_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.sensorTypes.edit', compact('sensorType'));
    }

    public function update(UpdateSensorTypeRequest $request, SensorType $sensorType)
    {
        $sensorType->update($request->all());

        return redirect()->route('admin.sensor-types.index');
    }

    public function show(SensorType $sensorType)
    {
        abort_if(Gate::denies('sensor_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sensorType->load('typeThings');

        return view('admin.sensorTypes.show', compact('sensorType'));
    }

    public function destroy(SensorType $sensorType)
    {
        abort_if(Gate::denies('sensor_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sensorType->delete();

        return back();
    }

    public function massDestroy(MassDestroySensorTypeRequest $request)
    {
        SensorType::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
