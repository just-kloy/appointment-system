<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CalendarEventRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;
use Carbon\Carbon;

/**
 * Class CalendarEventCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CalendarEventCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\CalendarEvent::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/calendar-event');
        CRUD::setEntityNameStrings('calendar event', 'calendar events');
    }

    /**
     * Define what happens when the List operation is loaded.
     */
    protected function setupListOperation()
    {
        CRUD::addColumn([
            'name' => 'client_id',
            'type' => 'select',
            'label' => 'Client',
            'entity' => 'client',
            'attribute' => 'name',
            'model' => 'App\Models\Client',
        ]);

        CRUD::addColumn([
            'name' => 'schedule',
            'type' => 'datetime',
            'label' => 'Appointment Start',
        ]);

        CRUD::addColumn([
            'name' => 'end_schedule',
            'type' => 'datetime',
            'label' => 'Appointment End',
        ]);

        CRUD::addColumn([
            'name' => 'employee.service_name',
            'type' => 'text',
            'label' => 'Service Name',
        ]);
    }

    /**
     * Define what happens when the Create operation is loaded.
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(CalendarEventRequest::class);

        CRUD::addField([
            'name' => 'client_id',
            'type' => 'select',
            'label' => 'Client',
            'entity' => 'client',
            'attribute' => 'name',
            'model' => 'App\Models\Client',
        ]);

        CRUD::addField([
            'name' => 'schedule',
            'type' => 'datetime',
            'label' => 'Start Date and Time',
        ]);

        CRUD::addField([
            'name' => 'end_schedule',
            'type' => 'datetime',
            'label' => 'End Date and Time',
        ]);
    }

    /**
     * Define what happens when the Update operation is loaded.
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    /**
     * Provide calendar events data for FullCalendar (returns JSON).
     */
    public function fetchEvents(Request $request)
    {
        $events = \App\Models\Client::with('employee')->get()
            ->map(function ($client) {
                $start = Carbon::parse($client->schedule);
                $end = Carbon::parse($client->end_schedule);

                return [
                    'id' => $client->id,
                    'title' => $client->name . ' _ ' .
                     ($client->employee->name ?? 'No Service'),
                    'start' => $start->toIso8601String(),
                    'end' => $end->toIso8601String(),
                ];
            });

        return response()->json($events);
    }

    /**
     * Show the calendar view with events data.
     */
    public function calendar()
    {
        $events = \App\Models\Client::with('employee')->get()
            ->map(function ($client) {
                $start = Carbon::parse($client->schedule);
                $end = Carbon::parse($client->end_schedule);

                return [
                    'title' => $client->name . ' _ ' . 
                    ($client->employee->name ?? 'No Service'),
                    'start' => $start->toIso8601String(),
                    'end' => $end->toIso8601String(),
                ];
            });

        return view('vendor.backpack.crud.calendar', [
            'events' => $events,
        ]);
    }
}
