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
        CRUD::addColumn([
            'name' => 'name',
            'type' => 'text',
            'label' => 'Employee Name',
        ]);

        CRUD::addColumn([
            'name' => 'contact_number',
            'type' => 'text',
            'label' => 'Contact Number',
        ]);

        CRUD::addColumn([
            'name' => 'services',
            'type' => 'json', // Displays JSON data as readable text
            'label' => 'Services Offered',
        ]);

        CRUD::addColumn([
            'name' => 'amount',
            'type' => 'number',
            'label' => 'Price (PHP)',
            'prefix' => '₱',
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
        CRUD::addField([
            'name' => 'name',
            'type' => 'text',
            'label' => 'Employee Name',
        ]);

        CRUD::addField([
            'name' => 'contact_number',
            'type' => 'text',
            'label' => 'Contact Number',
        ]);

        CRUD::addField([
            'name' => 'services',
            'type' => 'repeatable', // Allows multiple entries
            'label' => 'Services Offered',
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
                    'attributes' => ['step' => '0.01'], // To allow decimals
                    'prefix' => 'Php',
                ],
            ],
        ]);

        CRUD::addField([
            'name' => 'amount',
            'type' => 'number',
            'label' => 'Total Price (PHP)',
            'attributes' => ['step' => '0.01'], // Allows decimals
            'prefix' => 'Php',
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