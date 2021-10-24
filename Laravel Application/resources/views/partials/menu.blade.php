<aside class="main-sidebar sidebar-dark-primary elevation-4" style="min-height: 917px;">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img class="menu-logo" src="{{ asset('images/logo.png') }}"/></a>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item">
                    <a class="nav-link" href="{{ route("admin.home") }}">
                        <i class="fas fa-fw fa-tachometer-alt nav-icon">
                        </i>
                        <p>
                            {{ trans('global.dashboard') }}
                        </p>
                    </a>
                </li>
                @can('user_management_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/permissions*") ? "menu-open" : "" }} {{ request()->is("admin/roles*") ? "menu-open" : "" }} {{ request()->is("admin/users*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw nav-icon fas fa-users">

                            </i>
                            <p>
                                {{ trans('cruds.userManagement.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('permission_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.permissions.index") }}" class="nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-unlock-alt">

                                        </i>
                                        <p>
                                            {{ trans('cruds.permission.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('role_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.roles.index") }}" class="nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-briefcase">

                                        </i>
                                        <p>
                                            {{ trans('cruds.role.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('user_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-user">

                                        </i>
                                        <p>
                                            {{ trans('cruds.user.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('region_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.regions.index") }}" class="nav-link {{ request()->is("admin/regions") || request()->is("admin/regions/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-map-marked-alt">

                            </i>
                            <p>
                                {{ trans('cruds.region.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('point_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.points.index") }}" class="nav-link {{ request()->is("admin/points") || request()->is("admin/points/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-map-marker-alt">

                            </i>
                            <p>
                                {{ trans('cruds.point.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('sensor_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/things*") ? "menu-open" : "" }} {{ request()->is("admin/sensor-types*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw nav-icon fas fa-microchip">

                            </i>
                            <p>
                                {{ trans('cruds.sensor.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('thing_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.things.index") }}" class="nav-link {{ request()->is("admin/things") || request()->is("admin/things/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-microchip">

                                        </i>
                                        <p>
                                            {{ trans('cruds.thing.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('sensor_type_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.sensor-types.index") }}" class="nav-link {{ request()->is("admin/sensor-types") || request()->is("admin/sensor-types/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon far fa-list-alt">

                                        </i>
                                        <p>
                                            {{ trans('cruds.sensorType.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('maintenance_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/maintenance-events*") ? "menu-open" : "" }} {{ request()->is("admin/maintenance-event-types*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw nav-icon fas fa-wrench">

                            </i>
                            <p>
                                {{ trans('cruds.maintenance.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('maintenance_event_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.maintenance-events.index") }}" class="nav-link {{ request()->is("admin/maintenance-events") || request()->is("admin/maintenance-events/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-wrench">

                                        </i>
                                        <p>
                                            {{ trans('cruds.maintenanceEvent.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('maintenance_event_type_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.maintenance-event-types.index") }}" class="nav-link {{ request()->is("admin/maintenance-event-types") || request()->is("admin/maintenance-event-types/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon far fa-list-alt">

                                        </i>
                                        <p>
                                            {{ trans('cruds.maintenanceEventType.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                <li class="nav-item">
                    <a href="{{ route("admin.systemCalendar") }}" class="nav-link {{ request()->is("admin/system-calendar") || request()->is("admin/system-calendar/*") ? "active" : "" }}">
                        <i class="fas fa-fw fa-calendar nav-icon">

                        </i>
                        <p>
                            {{ trans('global.systemCalendar') }}
                        </p>
                    </a>
                </li>
                @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
                    @can('profile_password_edit')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'active' : '' }}" href="{{ route('profile.password.edit') }}">
                                <i class="fa-fw fas fa-key nav-icon">
                                </i>
                                <p>
                                    {{ trans('global.change_password') }}
                                </p>
                            </a>
                        </li>
                    @endcan
                @endif
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                        <p>
                            <i class="fas fa-fw fa-sign-out-alt nav-icon">

                            </i>
                            <p>{{ trans('global.logout') }}</p>
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
