<aside class="main-sidebar sidebar-dark-primary elevation-4" style="min-height: 917px;">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light">{{ trans('AMC') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
       
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs("admin.home") ? "active" : "" }}" href="{{ route("admin.home") }}">
                        <i class="fas fa-fw fa-tachometer-alt nav-icon">
                        </i>
                        <p>
                            {{ trans('global.dashboard') }}
                        </p>
                    </a>
                </li>
              
               
               
                @can('asset_management_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/categories*") ? "menu-open" : "" }} {{ request()->is("admin/locations*") ? "menu-open" : "" }} {{ request()->is("admin/statuses*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/categories*") ? "active" : "" }} {{ request()->is("admin/locations*") ? "active" : "" }} {{ request()->is("admin/statuses*") ? "active" : "" }}" href="#">
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
                                    <a href="{{ route("admin.categories.index") }}" class="nav-link {{ request()->is("admin/categories") || request()->is("admin/categories/*") ? "active" : "" }}">
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
                                    <a href="{{ route("admin.locations.index") }}" class="nav-link {{ request()->is("admin/locations") || request()->is("admin/locations/*") ? "active" : "" }}">
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
                                    <a href="{{ route("admin.statuses.index") }}" class="nav-link {{ request()->is("admin/statuses") || request()->is("admin/statuses/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-signal">

                                        </i>
                                        <p>
                                            {{ trans('Product Status') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan

                              @can('amc_status_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.amc-statuses.index") }}" class="nav-link {{ request()->is("admin/amc-statuses") || request()->is("admin/amc-statuses/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-signal">

                                        </i>
                                        <p>
                                            {{ trans('AMC Status') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan

                        </ul>
                    </li>
                @endcan
                @can('asset_allocation_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/allocations*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/allocations*") ? "active" : "" }}" href="#">
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
                                    <a href="{{ route("admin.allocations.index") }}" class="nav-link {{ request()->is("admin/allocations") || request()->is("admin/allocations/*") ? "active" : "" }}">
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

                  @can('asset_allocation_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/amc-status-allocs*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/amc-status-allocs*") ? "active" : "" }}" href="#">
                            <i class="fa-fw nav-icon fas fa-address-card">

                            </i>
                            <p>
                                {{ trans('Asset AMC') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('allocation_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.amc-status-allocs.index") }}" class="nav-link {{ request()->is("admin/amc-status-allocs") || request()->is("admin/amc-status-allocs/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon far fa-address-book">

                                        </i>
                                        <p>
                                            {{ trans('AMC Status') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan

                             @can('allocation_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.ams_status_dash.index") }}" class="nav-link {{ request()->is("admin/ams_status_dash") || request()->is("admin/ams_status_dash/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon far fa-address-book">

                                        </i>
                                        <p>
                                            {{ trans('AMS Status Dashboard') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan


                        </ul>
                    </li>
                @endcan


                   {{-- @can('asset_amc_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/amc-status-allocs*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fab fa-affiliatetheme c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.assetAmc.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('amc_status_alloc_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.amc-status-allocs.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/amc-status-allocs") || request()->is("admin/amc-status-allocs/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.amcStatusAlloc.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan --}}



        

                @can('report_access')
                <li class="nav-item has-treeview {{ request()->is("admin/AllocationReport*") ? "menu-open" : "" }} ">
                    <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/AllocationReport*") ? "active" : "" }} " href="#">
                       
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
                                <a href="{{ route("admin.reports.AllocationReport") }}" class="nav-link {{ request()->is("admin/AllocationReport") || request()->is("admin/AllocationReport/*") ? "active" : "" }}">
                                    <i class="fa-fw nav-icon fas fa-book">
    
                                    </i>
                                    <p>
                                        {{ trans('Allocation Reports') }}
                                    </p>
                                </a>
                            </li>
                        @endcan

                          @can('allotQRcodeReport_access')
                            <li class="nav-item">
                                <a href="{{ route("admin.reports.QRCodeAllocationReport") }}" class="nav-link {{ request()->is("admin/AllocationQRCodeReport") || request()->is("admin/AllocationQRCodeReport/*") ? "active" : "" }}">
                                    <i class="fa-fw nav-icon fas fa-book">
    
                                    </i>
                                    <p>
                                        {{ trans('QR Code Alloc Reports') }}
                                    </p>
                                </a>
                            </li>
                        @endcan
                     
                    </ul>
                </li>
            @endcan
                @can('employee_management_access')
                <li class="nav-item has-treeview {{ request()->is("admin/departments*") ? "menu-open" : "" }} {{ request()->is("admin/employees*") ? "menu-open" : "" }}">
                    <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/departments*") ? "active" : "" }} {{ request()->is("admin/employees*") ? "active" : "" }}" href="#">
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
                                <a href="{{ route("admin.departments.index") }}" class="nav-link {{ request()->is("admin/departments") || request()->is("admin/departments/*") ? "active" : "" }}">
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
                                <a href="{{ route("admin.employees.index") }}" class="nav-link {{ request()->is("admin/employees") || request()->is("admin/employees/*") ? "active" : "" }}">
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
                @can('user_management_access')
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
                        {{-- @can('team_access')
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
                    @endif --}}
                    </ul>
                </li>
            @endcan
               
                @can('school_management_access')
                <li class="nav-item has-treeview {{ request()->is("admin/schools*") ? "menu-open" : "" }}">
                    <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/schools*") ? "active" : "" }}" href="#">
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
                                <a href="{{ route("admin.schools.index") }}" class="nav-link {{ request()->is("admin/schools") || request()->is("admin/schools/*") ? "active" : "" }}">
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
                @can('task_management_access')
                <li class="nav-item has-treeview {{ request()->is("admin/task-statuses*") ? "menu-open" : "" }} {{ request()->is("admin/task-tags*") ? "menu-open" : "" }} {{ request()->is("admin/tasks*") ? "menu-open" : "" }} {{ request()->is("admin/tasks-calendars*") ? "menu-open" : "" }}">
                    <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/task-statuses*") ? "active" : "" }} {{ request()->is("admin/task-tags*") ? "active" : "" }} {{ request()->is("admin/tasks*") ? "active" : "" }} {{ request()->is("admin/tasks-calendars*") ? "active" : "" }}" href="#">
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
                                <a href="{{ route("admin.task-statuses.index") }}" class="nav-link {{ request()->is("admin/task-statuses") || request()->is("admin/task-statuses/*") ? "active" : "" }}">
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
                                <a href="{{ route("admin.task-tags.index") }}" class="nav-link {{ request()->is("admin/task-tags") || request()->is("admin/task-tags/*") ? "active" : "" }}">
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
                                <a href="{{ route("admin.tasks.index") }}" class="nav-link {{ request()->is("admin/tasks") || request()->is("admin/tasks/*") ? "active" : "" }}">
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
                                <a href="{{ route("admin.tasks-calendars.index") }}" class="nav-link {{ request()->is("admin/tasks-calendars") || request()->is("admin/tasks-calendars/*") ? "active" : "" }}">
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
            @endcan
           
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