<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EmployeeRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class EmployeeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class EmployeeCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Employee::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/employee');
        CRUD::setEntityNameStrings('employee', 'employees');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @return void
     */
    protected function setupListOperation()
    {
        // Customize the columns shown in the table
        // Employee name
    CRUD::addColumn([
        'name' => 'name',
        'type' => 'text',
        'label' => 'Employee Name',
    ]);

    // Contact number
    CRUD::addColumn([
        'name' => 'contact_number',
        'type' => 'text',
        'label' => 'Contact Number',
    ]);

    // Service name
    CRUD::addColumn([
        'name' => 'service_name',
        'type' => 'text',
        'label' => 'Service',
    ]);

    // Service price
    CRUD::addColumn([
        'name' => 'amount',
        'type' => 'number',
        'label' => 'Service Price',
        'prefix' => 'Php ', // Adds PHP currency symbol
    ]);
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(EmployeeRequest::class);

        // Customize the fields in the Create form
        // Employee name
    CRUD::addField([
        'name' => 'name',
        'type' => 'text',
        'label' => 'Employee Name',
    ]);

    // Contact number
    CRUD::addField([
        'name' => 'contact_number',
        'type' => 'text',
        'label' => 'Contact Number',
    ]);

    // Service name
    CRUD::addField([
        'name' => 'service_name',
        'type' => 'text',
        'label' => 'Service',
    ]);

    // Service price
    CRUD::addField([
        'name' => 'amount',
        'type' => 'number',
        'label' => 'Service Price',
        'prefix' => 'Php', // Adds PHP currency symbol
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