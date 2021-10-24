@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-4 col-sm-6 col-12">
            <div style="min-height: 318px;" class="card card-widget widget-user-2 shadow-sm">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-warning">
                    <div class="widget-user-image">
                        <img class="img-circle elevation-2" src="https://redcase.gr/kmz/sensor.png" alt="">
                    </div>
                    <!-- /.widget-user-image -->
                    <h3 class="widget-user-username">Point of Interest</h3>
                    <h5 class="widget-user-desc">{{ $point->name }}</h5>
                    <span class="info-box-text">{!! $point->description !!}</span>
                </div>
                <div class="card-footer p-0">
                    <ul class="nav flex-column">
                        @foreach($point->sensors as $key => $sensors)
                            <li class="nav-item">
                                <a href="{{ route('admin.things.show', $sensors->id) }}" class="nav-link">
                                    <i class="fas fa-fw fa-microchip"></i>
                                    {{ $sensors->eui }}<span
                                        class="float-right badge bg-secondary">{{ $sensors->type->name }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div style="height: 318px;" id="poi-map"></div>
            </div>
        </div>
    </div>
    <div class="card">
        @includeIf('admin.points.relationships.poiMaintenanceEvents', ['maintenanceEvents' => $point->poiMaintenanceEvents])
    </div>

@endsection

@section('scripts')
    @parent

    <script>
        var map = L.map('poi-map').setView([38.9207692, 22.3398289], 11);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        L.marker([{{$point->latitude}}, {{$point->longitude}}]).addTo(map)
            .bindPopup('{!! $point->name !!}')
            .openPopup();
    </script>


@endsection
