<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyThingRequest;
use App\Http\Requests\StoreThingRequest;
use App\Http\Requests\UpdateThingRequest;
use App\Models\SensorType;
use App\Models\Thing;
use BaoPham\DynamoDb\Facades\DynamoDb;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ThingController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('thing_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Thing::with(['type'])->select(sprintf('%s.*', (new Thing())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'thing_show';
                $editGate = 'thing_edit';
                $deleteGate = 'thing_delete';
                $crudRoutePart = 'things';

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

            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('eui', function ($row) {
                return $row->eui ? $row->eui : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'type']);

            return $table->make(true);
        }

        $sensor_types = SensorType::get();

        return view('admin.things.index', compact('sensor_types'));
    }

    public function create()
    {
        abort_if(Gate::denies('thing_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $types = SensorType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.things.create', compact('types'));
    }

    public function store(StoreThingRequest $request)
    {
        $thing = Thing::create($request->all());

        return redirect()->route('admin.things.index');
    }

    public function edit(Thing $thing)
    {
        abort_if(Gate::denies('thing_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $types = SensorType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $thing->load('type');

        return view('admin.things.edit', compact('types', 'thing'));
    }

    public function update(UpdateThingRequest $request, Thing $thing)
    {
        $thing->update($request->all());

        return redirect()->route('admin.things.index');
    }

    public function show(Thing $thing)
    {
        abort_if(Gate::denies('thing_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $thing->load('type');

        return view('admin.things.show', compact('thing'));
    }

    public function destroy(Thing $thing)
    {
        abort_if(Gate::denies('thing_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $thing->delete();

        return back();
    }

    public function massDestroy(MassDestroyThingRequest $request)
    {
        Thing::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
