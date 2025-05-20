<div class="sidebar-brand">
    <a href="index.html"> <img alt="image" src="{{ asset('admin/img/logo.png') }}" class="header-logo" /> <span
            class="logo-name">Otika</span>
    </a>
</div>
<ul class="sidebar-menu">
    <li class="menu-header">Main</li>
    <li class="dropdown">
        <a href="index.html" class="nav-link"><i data-feather="monitor"></i><span>Dashboard</span></a>
    </li>
<!-- Permission-based menu items -->

@if(auth()->user()->can('patient.list') || auth()->user()->can('patient.create') || auth()->user()->can('patient.update') || auth()->user()->can('patient.delete'))
    <li class="dropdown {{ request()->routeIs('patient.*') ? 'active' : '' }}">
        <a href="#" class="menu-toggle nav-link has-dropdown"><i
                data-feather="briefcase"></i><span>Patients</span></a>
        <ul class="dropdown-menu">
            @if(auth()->user()->can('patient.list'))
            <li class="{{ request()->routeIs('patient.index') ? 'active' : '' }}">
                <a class="nav-link " href="{{ route('patient.index') }}">Patients Directory</a>
            </li>
            @endif
            @if(auth()->user()->can('patient.create'))
            <li class="{{ request()->routeIs('patient.create') ? 'active' : '' }}">
                <a class="nav-link " href="{{ route('patient.create') }}">Registration</a>
            </li>
            @endif
        </ul>
    </li>
@endif

@if(auth()->user()->can('appointment.list') || auth()->user()->can('doctor_availability.list') || auth()->user()->can('approved_appointments.list'))
    <li class="dropdown {{ request()->routeIs('appointment.*') ? 'active' : '' }}">
        <a href="#" class="menu-toggle nav-link has-dropdown"><i
                data-feather="briefcase"></i><span>Appointments</span></a>
        <ul class="dropdown-menu">
            @if(auth()->user()->can('doctor_availability.list'))
            <li class="{{ request()->routeIs('appointment.availability') ? 'active' : '' }}">
                <a class="nav-link " href="{{ route('appointment.availability') }}">Doctor Availability</a>
            </li>
            @endif
            @if(auth()->user()->can('appointment.list'))
            <li class="{{ request()->routeIs('appointment.list') ? 'active' : '' }}">
                <a class="nav-link " href="{{ route('appointment.list') }}">Appointment List</a>
            </li>
            @endif
            @if(auth()->user()->can('approved_appointments.list'))
            <li class="{{ request()->routeIs('appointment.approve.list') ? 'active' : '' }}">
                <a class="nav-link " href="{{ route('appointment.approve.list') }}">Approved Appointments</a>
            </li>
            @endif
        </ul>
    </li>
@endif

@if(auth()->user()->can('checkin.list') || auth()->user()->can('checkin.create'))
    <li class="dropdown {{ request()->routeIs('consultation.*') ? 'active' : '' }}">
        <a href="#" class="menu-toggle nav-link has-dropdown"><i
                data-feather="briefcase"></i><span>Consultations</span></a>
        <ul class="dropdown-menu">
            @if(auth()->user()->can('checkin.list') || auth()->user()->can('checkin.create'))
            <li class="{{ request()->routeIs('consultation.checkin') ? 'active' : '' }}">
                <a class="nav-link " href="{{ route('consultation.checkin') }}">Checkin Patients</a>
            </li>
            @endif
        </ul>
    </li>
@endif

@if(auth()->user()->can('doctor.list') || auth()->user()->can('doctor.create') || auth()->user()->can('schedule.list') || auth()->user()->can('schedule.create'))
    <li class="dropdown {{ request()->routeIs('doctor.*') ? 'active' : '' }}">
        <a href="#" class="menu-toggle nav-link has-dropdown"><i
                data-feather="briefcase"></i><span>Doctors</span></a>
        <ul class="dropdown-menu">
            @if(auth()->user()->can('doctor.list'))
            <li class="{{ request()->routeIs('doctor.index') ? 'active' : '' }}">
                <a class="nav-link " href="{{ route('doctor.index') }}">Doctors Directory</a>
            </li>
            @endif
            @if(auth()->user()->can('doctor.create'))
            <li class="{{ request()->routeIs('doctor.create') ? 'active' : '' }}">
                <a class="nav-link " href="{{ route('doctor.create') }}">Registration</a>
            </li>
            @endif
            @if(auth()->user()->can('schedule.create'))
            <li class="{{ request()->routeIs('doctor.schedule.create') ? 'active' : '' }}">
                <a class="nav-link " href="{{ route('doctor.schedule.create') }}">Create Schedule</a>
            </li>
            @endif
            @if(auth()->user()->can('schedule.list'))
            <li class="{{ request()->routeIs('doctor.schedule.list') ? 'active' : '' }}">
                <a class="nav-link " href="{{ route('doctor.schedule.list') }}">Schedule List</a>
            </li>
            @endif
        </ul>
    </li>
@endif

    @if (auth()->user()->hasManagementPermissions())
        <li class="menu-header">Management</li>
        <li
            class="dropdown {{ request()->routeIs('users.*', 'role.*', 'branch.*', 'department.*', 'designation.*', 'permission.*') ? 'active' : '' }}">
            <a href="#" class="menu-toggle nav-link has-dropdown ">
                <i data-feather="briefcase"></i><span>Management</span>
            </a>
            <ul class="dropdown-menu">
                @can('user.list')
                    <li class="{{ request()->routeIs('users.index') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('users.index') }}">Users</a>
                    </li>
                @endcan

                @can('role.list')
                    <li class="{{ request()->routeIs('role.index') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('role.index') }}">Roles</a>
                    </li>
                @endcan

                @can('branch.list')
                    <li class="{{ request()->routeIs('branch.index') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('branch.index') }}">Branch</a>
                    </li>
                @endcan

                @can('department.list')
                    <li class="{{ request()->routeIs('department.index') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('department.index') }}">Department</a>
                    </li>
                @endcan

                @can('designation.list')
                    <li class="{{ request()->routeIs('designation.index') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('designation.index') }}">Designation</a>
                    </li>
                @endcan

                @can('permission.list')
                    <li class="{{ request()->routeIs('permission.index') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('permission.index') }}">Permissions</a>
                    </li>
                @endcan
            </ul>
        </li>
    @endif
</ul>
</aside>
