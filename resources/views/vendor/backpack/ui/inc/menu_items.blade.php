{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<x-backpack::menu-item title="Users" icon="la la-user" :link="backpack_url('user')" />
<x-backpack::menu-item title="Employees" icon="las la-id-badge" :link="backpack_url('employee')" />
<x-backpack::menu-item title="Clients" icon="la la-black-tie" :link="backpack_url('client')" />
{{-- <x-backpack::menu-item title="Calendar events" icon="la la-question" :link="backpack_url('calendar-event')" /> --}}
<x-backpack::menu-item title="Calendar" icon="la la-calendar" :link="backpack_url('calendar')" />
