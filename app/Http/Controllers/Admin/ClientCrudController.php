<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ClientRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ClientCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ClientCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Client::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/client');
        CRUD::setEntityNameStrings('client', 'clients');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @return void
     */
    protected function setupListOperation()
    {
        // Define the columns for the List view
        CRUD::addColumn([
            'name' => 'name',
            'type' => 'text',
            'label' => 'Client Name',
        ]);

        CRUD::addColumn([
            'name' => 'contact_number',
            'type' => 'text',
            'label' => 'Contact Number',
        ]);

        CRUD::addColumn([
            'name' => 'employee_id',
            'type' => 'select',
            'label' => 'Assigned Employee',
            'entity' => 'employee', // Relationship method in the Client model
            'attribute' => 'name', // Employee name to display
            'model' => 'App\Models\Employee', // Employee model
        ]);

        CRUD::addColumn([
            'name' => 'services',
            'type' => 'json', // Displays the services as JSON data
            'label' => 'Services Selected',
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
        CRUD::setValidation(ClientRequest::class);

        // Define the fields for the Create form
        CRUD::addField([
            'name' => 'name',
            'type' => 'text',
            'label' => 'Client Name',
        ]);

        CRUD::addField([
            'name' => 'contact_number',
            'type' => 'text',
            'label' => 'Contact Number',
        ]);

        CRUD::addField([
            'name' => 'employee_id',
            'type' => 'select2',
            'label' => 'Assign Employee',
            'entity' => 'employee', // Relationship method in the Client model
            'attribute' => 'name', // Employee name to display
            'model' => 'App\Models\Employee', // Employee model
        ]);

        CRUD::addField([
            'name' => 'services',
            'type' => 'repeatable', // Allows selecting multiple services
            'label' => 'Services',
            'fields' => [
                [
                    'name' => 'service_name',
                    'type' => 'text',
                    'label' => 'Service Name',
                ],
                [
                    'name' => 'service_price',
                    'type' => 'number',
                    'label' => 'Price ',
                    'attributes' => ['step' => '0.01'], // Allows decimals
                    'prefix' => 'Php',
                ],
            ],
        ]);

        CRUD::addField([
            'name' => 'schedule',
            'type' => 'datetime_picker',
            'label' => 'Appointment Schedule',
        ]);
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation(); // Reuse the fields from Create
    }
}