<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyPointRequest;
use App\Http\Requests\StorePointRequest;
use App\Http\Requests\UpdatePointRequest;
use App\Models\Point;
use App\Models\Thing;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PointsController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('point_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Point::with(['sensors'])->select(sprintf('%s.*', (new Point())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'point_show';
                $editGate = 'point_edit';
                $deleteGate = 'point_delete';
                $crudRoutePart = 'points';

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
            $table->editColumn('latitude', function ($row) {
                return $row->latitude ? $row->latitude : '';
            });
            $table->editColumn('longitude', function ($row) {
                return $row->longitude ? $row->longitude : '';
            });
            $table->editColumn('sensors', function ($row) {
                $labels = [];
                foreach ($row->sensors as $sensor) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $sensor->eui);
                }

                return implode(' ', $labels);
            });

            $table->rawColumns(['actions', 'placeholder', 'sensors']);

            return $table->make(true);
        }

        return view('admin.points.index');
    }

    public function create()
    {
        abort_if(Gate::denies('point_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sensors = Thing::pluck('eui', 'id');

        return view('admin.points.create', compact('sensors'));
    }

    public function store(StorePointRequest $request)
    {
        $point = Point::create($request->all());
        $point->sensors()->sync($request->input('sensors', []));
        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $point->id]);
        }

        return redirect()->route('admin.points.index');
    }

    public function edit(Point $point)
    {
        abort_if(Gate::denies('point_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sensors = Thing::pluck('eui', 'id');

        $point->load('sensors');

        return view('admin.points.edit', compact('sensors', 'point'));
    }

    public function update(UpdatePointRequest $request, Point $point)
    {
        $point->update($request->all());
        $point->sensors()->sync($request->input('sensors', []));

        return redirect()->route('admin.points.index');
    }

    public function show(Point $point)
    {
        abort_if(Gate::denies('point_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $point->load('sensors', 'poiMaintenanceEvents');

        return view('admin.points.show', compact('point'));
    }

    public function destroy(Point $point)
    {
        abort_if(Gate::denies('point_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $point->delete();

        return back();
    }

    public function massDestroy(MassDestroyPointRequest $request)
    {
        Point::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('point_create') && Gate::denies('point_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Point();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
