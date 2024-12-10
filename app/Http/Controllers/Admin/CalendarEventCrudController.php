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
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\CalendarEvent::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/calendar-event');
        CRUD::setEntityNameStrings('calendar event', 'calendar events');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::addColumn([
            'name' => 'client_id',
            'type' => 'select',
            'label' => 'Client',
            'entity' => 'client',  // The relationship in the model
            'attribute' => 'name',  // Field from the Client model
            'model' => 'App\Models\Client',
        ]);

        CRUD::addColumn([
            'name' => 'schedule',
            'type' => 'datetime',
            'label' => 'Appointment Schedule',
        ]);
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @return void
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
            'label' => 'Date and Time',
        ]);
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    /**
     * Provide calendar events data for FullCalendar (returns JSON).
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchEvents(Request $request)
    {
        $events = \App\Models\Client::all()  // Fetch all clients
            ->map(function ($client) {
                $schedule = Carbon::parse($client->schedule);  // Convert schedule to Carbon instance

                return [
                    'id' => $client->id,
                    'title' => $client->name,  // Display the client name
                    'start' => $schedule->toIso8601String(),  // Convert to ISO 8601 string
                    'end' => $schedule->toIso8601String(),  // Same date (optional)
                ];
            });

        return response()->json($events);
    }

    /**
     * Show the calendar view with events data.
     * 
     * @return \Illuminate\View\View
     */
    public function calendar()
    {
        // Fetch all clients' appointments
        $events = \App\Models\Client::all()
            ->map(function ($client) {
                $schedule = Carbon::parse($client->schedule);  // Convert schedule to Carbon instance

                return [
                    'title' => $client->name, // Client name as event title
                    'start' => $schedule->toIso8601String(), // Appointment date
                    'end' => $schedule->toIso8601String(), // Optional: Same date as end
                ];
            });

        return view('vendor.backpack.crud.calendar', [
            'events' => $events, // Pass events to the calendar view
        ]);
    }
}
