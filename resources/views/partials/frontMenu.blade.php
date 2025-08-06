<aside class="main-sidebar sidebar-dark-primary elevation-4" style="min-height: 917px;">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light">{{ trans('AMS') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
       
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs("frontend.home") ? "active" : "" }}" href="{{ route("frontend.home") }}">
                        <i class="fas fa-fw fa-tachometer-alt nav-icon">
                        </i>
                        <p>
                            {{ trans('global.dashboard') }}
                        </p>
                    </a>
                </li>
              
                @can('school_management_access')
                    <li class="nav-item has-treeview {{ request()->is("schools*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("schools*") ? "active" : "" }}" href="#">
                            <i class="fa-fw nav-icon fas fa-school">

                            </i>
                            <p>
                                {{ trans('cruds.schoolManagement.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('school_access')
                                <li class="nav-item">
                                    <a href="{{ route("frontend.schools.index") }}" class="nav-link {{ request()->is("schools") || request()->is("schools/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-graduation-cap">

                                        </i>
                                        <p>
                                            {{ trans('cruds.school.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('asset_management_access')
                    <li class="nav-item has-treeview {{ request()->is("categories*") ? "menu-open" : "" }} {{ request()->is("locations*") ? "menu-open" : "" }} {{ request()->is("statuses*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("categories*") ? "active" : "" }} {{ request()->is("locations*") ? "active" : "" }} {{ request()->is("statuses*") ? "active" : "" }}" href="#">
                            <i class="fa-fw nav-icon fas fa-book">

                            </i>
                            <p>
                                {{ trans('cruds.assetManagement.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('category_access')
                                <li class="nav-item">
                                    <a href="{{ route("frontend.categories.index") }}" class="nav-link {{ request()->is("categories") || request()->is("categories/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-align-center">

                                        </i>
                                        <p>
                                            {{ trans('cruds.category.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('location_access')
                                <li class="nav-item">
                                    <a href="{{ route("frontend.locations.index") }}" class="nav-link {{ request()->is("locations") || request()->is("locations/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-map-marker-alt">

                                        </i>
                                        <p>
                                            {{ trans('cruds.location.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('status_access')
                                <li class="nav-item">
                                    <a href="{{ route("frontend.statuses.index") }}" class="nav-link {{ request()->is("statuses") || request()->is("statuses/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-signal">

                                        </i>
                                        <p>
                                            {{ trans('cruds.status.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('asset_allocation_access')
                    <li class="nav-item has-treeview {{ request()->is("allocations*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("allocations*") ? "active" : "" }}" href="#">
                            <i class="fa-fw nav-icon fas fa-address-card">

                            </i>
                            <p>
                                {{ trans('cruds.assetAllocation.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('allocation_access')
                                <li class="nav-item">
                                    <a href="{{ route("frontend.allocations.index") }}" class="nav-link {{ request()->is("allocations") || request()->is("allocations/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon far fa-address-book">

                                        </i>
                                        <p>
                                            {{ trans('cruds.allocation.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('report_access')
                <li class="nav-item has-treeview {{ request()->is("AllocationsReport*") ? "menu-open" : "" }} ">
                    <a class="nav-link nav-dropdown-toggle {{ request()->is("AllocationsReport*") ? "active" : "" }} " href="#">
                       
                       <i class="fa-fw nav-icon fas fa-clipboard">
    
                        </i>
                        <p>
                            {{ trans('Reports') }}
                            <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('allotReport_access')
                            <li class="nav-item">
                                <a href="{{ route("frontend.reports.AllocationsReport") }}" class="nav-link {{ request()->is("AllocationsReport") || request()->is("AllocationReport*") ? "active" : "" }}">
                                    <i class="fa-fw nav-icon fas fa-book">
    
                                    </i>
                                    <p>
                                        {{ trans('Allocation Reports') }}
                                    </p>
                                </a>
                            </li>
                        @endcan
                     
                    </ul>
                </li>
            @endcan
                {{-- @can('user_management_access')
                <li class="nav-item has-treeview {{ request()->is("admin/permissions*") ? "menu-open" : "" }} {{ request()->is("admin/roles*") ? "menu-open" : "" }} {{ request()->is("admin/users*") ? "menu-open" : "" }} {{ request()->is("admin/teams*") ? "menu-open" : "" }}">
                    <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/permissions*") ? "active" : "" }} {{ request()->is("admin/roles*") ? "active" : "" }} {{ request()->is("admin/users*") ? "active" : "" }} {{ request()->is("admin/teams*") ? "active" : "" }}" href="#">
                        <i class="fa-fw nav-icon fas fa-user">

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
                        @can('team_access')
                            <li class="nav-item">
                                <a href="{{ route("admin.teams.index") }}" class="nav-link {{ request()->is("admin/teams") || request()->is("admin/teams/*") ? "active" : "" }}">
                                    <i class="fa-fw nav-icon fas fa-users">

                                    </i>
                                    <p>
                                        {{ trans('cruds.team.title') }}
                                    </p>
                                </a>
                            </li>
                        @endcan
                        @if(\Illuminate\Support\Facades\Schema::hasColumn('teams', 'owner_id') && \App\Models\Team::where('owner_id', auth()->user()->id)->exists())
                        <li class="nav-item">
                            <a class="{{ request()->is("admin/team-members") || request()->is("admin/team-members/*") ? "active" : "" }} nav-link" href="{{ route("admin.team-members.index") }}">
                                <i class="fa-fw fa fa-users nav-icon">
                                </i>
                                <p>
                                    {{ trans("global.team-members") }}
                                </p>
                            </a>
                        </li>
                    @endif
                    </ul>
                </li>
            @endcan --}}
                @can('employee_management_access')
                    <li class="nav-item has-treeview {{ request()->is("departments*") ? "menu-open" : "" }} {{ request()->is("employees*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("departments*") ? "active" : "" }} {{ request()->is("employees*") ? "active" : "" }}" href="#">
                            <i class="fa-fw nav-icon fas fa-users">

                            </i>
                            <p>
                                {{ trans('cruds.employeeManagement.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('department_access')
                                <li class="nav-item">
                                    <a href="{{ route("frontend.departments.index") }}" class="nav-link {{ request()->is("departments") || request()->is("departments/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-archway">

                                        </i>
                                        <p>
                                            {{ trans('cruds.department.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('employee_access')
                                <li class="nav-item">
                                    <a href="{{ route("frontend.employees.index") }}" class="nav-link {{ request()->is("employees") || request()->is("employees/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon far fa-address-book">

                                        </i>
                                        <p>
                                            {{ trans('cruds.employee.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                {{-- @can('task_management_access')
                <li class="nav-item has-treeview {{ request()->is("task-statuses*") ? "menu-open" : "" }} {{ request()->is("task-tags*") ? "menu-open" : "" }} {{ request()->is("tasks*") ? "menu-open" : "" }} {{ request()->is("tasks-calendars*") ? "menu-open" : "" }}">
                    <a class="nav-link nav-dropdown-toggle {{ request()->is("task-statuses*") ? "active" : "" }} {{ request()->is("task-tags*") ? "active" : "" }} {{ request()->is("tasks*") ? "active" : "" }} {{ request()->is("tasks-calendars*") ? "active" : "" }}" href="#">
                        <i class="fa-fw nav-icon fas fa-list">

                        </i>
                        <p>
                            {{ trans('cruds.taskManagement.title') }}
                            <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('task_status_access')
                            <li class="nav-item">
                                <a href="{{ route("frontend.task-statuses.index") }}" class="nav-link {{ request()->is("task-statuses") || request()->is("task-statuses/*") ? "active" : "" }}">
                                    <i class="fa-fw nav-icon fas fa-server">

                                    </i>
                                    <p>
                                        {{ trans('cruds.taskStatus.title') }}
                                    </p>
                                </a>
                            </li>
                        @endcan
                        @can('task_tag_access')
                            <li class="nav-item">
                                <a href="{{ route("frontend.task-tags.index") }}" class="nav-link {{ request()->is("task-tags") || request()->is("task-tags/*") ? "active" : "" }}">
                                    <i class="fa-fw nav-icon fas fa-server">

                                    </i>
                                    <p>
                                        {{ trans('cruds.taskTag.title') }}
                                    </p>
                                </a>
                            </li>
                        @endcan
                        @can('task_access')
                            <li class="nav-item">
                                <a href="{{ route("frontend.tasks.index") }}" class="nav-link {{ request()->is("tasks") || request()->is("tasks/*") ? "active" : "" }}">
                                    <i class="fa-fw nav-icon fas fa-briefcase">

                                    </i>
                                    <p>
                                        {{ trans('cruds.task.title') }}
                                    </p>
                                </a>
                            </li>
                        @endcan
                        @can('tasks_calendar_access')
                            <li class="nav-item">
                                <a href="{{ route("frontend.tasks-calendars.index") }}" class="nav-link {{ request()->is("tasks-calendars") || request()->is("tasks-calendars/*") ? "active" : "" }}">
                                    <i class="fa-fw nav-icon fas fa-calendar">

                                    </i>
                                    <p>
                                        {{ trans('cruds.tasksCalendar.title') }}
                                    </p>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan --}}
           
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs("frontend.profile.index") ? "active" : "" }}" href="{{ route("frontend.profile.index") }}">
                <i class="fas fa-fw nav-icon fa-user">
                </i>
                <p>
                    {{ trans('My Profile') }}
                </p>
            </a>
        </li>
                
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