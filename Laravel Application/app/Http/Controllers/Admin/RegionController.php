<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyRegionRequest;
use App\Http\Requests\StoreRegionRequest;
use App\Http\Requests\UpdateRegionRequest;
use App\Models\Point;
use App\Models\Region;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class RegionController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('region_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Region::with(['points', 'managers'])->select(sprintf('%s.*', (new Region())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'region_show';
                $editGate = 'region_edit';
                $deleteGate = 'region_delete';
                $crudRoutePart = 'regions';

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
            $table->editColumn('points', function ($row) {
                $labels = [];
                foreach ($row->points as $point) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $point->name);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('managers', function ($row) {
                $labels = [];
                foreach ($row->managers as $manager) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $manager->name);
                }

                return implode(' ', $labels);
            });

            $table->rawColumns(['actions', 'placeholder', 'points', 'managers']);

            return $table->make(true);
        }

        return view('admin.regions.index');
    }

    public function create()
    {
        abort_if(Gate::denies('region_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $points = Point::pluck('name', 'id');

        $managers = User::pluck('name', 'id');

        return view('admin.regions.create', compact('points', 'managers'));
    }

    public function store(StoreRegionRequest $request)
    {
        $region = Region::create($request->all());
        $region->points()->sync($request->input('points', []));
        $region->managers()->sync($request->input('managers', []));

        return redirect()->route('admin.regions.index');
    }

    public function edit(Region $region)
    {
        abort_if(Gate::denies('region_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $points = Point::pluck('name', 'id');

        $managers = User::pluck('name', 'id');

        $region->load('points', 'managers');

        return view('admin.regions.edit', compact('points', 'managers', 'region'));
    }

    public function update(UpdateRegionRequest $request, Region $region)
    {
        $region->update($request->all());
        $region->points()->sync($request->input('points', []));
        $region->managers()->sync($request->input('managers', []));

        return redirect()->route('admin.regions.index');
    }

    public function show(Region $region)
    {
        abort_if(Gate::denies('region_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $region->load('points', 'managers');

        return view('admin.regions.show', compact('region'));
    }

    public function destroy(Region $region)
    {
        abort_if(Gate::denies('region_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $region->delete();

        return back();
    }

    public function massDestroy(MassDestroyRegionRequest $request)
    {
        Region::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
