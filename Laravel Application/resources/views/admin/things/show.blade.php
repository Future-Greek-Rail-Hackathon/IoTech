@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-blue"><i class="fa-fw fas fa-microchip"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">{{ trans('cruds.thing.fields.type') }}</span>
                    <span class="info-box-number">{{ $thing->type->name ?? '' }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-blue"><i class="fa-fw fas fa-microchip"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">{{ trans('cruds.thing.fields.name') }}</span>
                    <span class="info-box-number">{{ $thing->name ?? '' }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-blue"><i class="fa-fw fas fa-microchip"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">{{ trans('cruds.thing.fields.eui') }}</span>
                    <span class="info-box-number">{{ $thing->eui ?? '' }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-blue"><i class="fa-fw fas fa-microchip"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">{{ trans('cruds.thing.fields.installed_at') }}</span>
                    <span class="info-box-number">{{ $thing->installed_at ?? '' }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fas fa-fw fa-thermometer-quarter"></i>
                        Temperature Chart
                    </div>
                </div>
                <div class="card-body">
                    <!-- Chart's container -->
                    <div id="temperature_chart" style="height: 500px;"></div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fas fa-fw fa-wave-square"></i>
                        Vibration Chart
                    </div>
                </div>
                <div class="card-body">
                    <!-- Chart's container -->
                    <div id="deformity_chart" style="height: 500px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charting library -->
    <script src="https://unpkg.com/echarts/dist/echarts.min.js"></script>
    <!-- Chartisan -->
    <script src="https://unpkg.com/@chartisan/echarts/dist/chartisan_echarts.js"></script>
    <!-- Your application script -->
    <script>
        const temperature_chart = new Chartisan({
            el: '#temperature_chart',
            url: "@chart('temperature_chart')",
        });
        const deformity_chart = new Chartisan({
            el: '#deformity_chart',
            url: "@chart('deformity_chart')",
        });
    </script>



@endsection
