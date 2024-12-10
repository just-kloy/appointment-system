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
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Client::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/client');
        CRUD::setEntityNameStrings('client', 'clients');
    }

    /**
     * Define what happens when the List operation is loaded.
     */
    protected function setupListOperation()
    {
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
            'entity' => 'employee',
            'attribute' => 'name',
            'model' => 'App\Models\Employee',
        ]);

        CRUD::addColumn([
            'name' => 'schedule',
            'type' => 'datetime',
            'label' => 'Appointment Schedule',
        ]);
    }

    /**
     * Define what happens when the Create operation is loaded.
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ClientRequest::class);

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
            'type' => 'select',
            'label' => 'Assign Employee',
            'entity' => 'employee',
            'attribute' => 'name',
            'model' => 'App\Models\Employee',
            'wrapper' => ['class' => 'form-group col-md-6'],
            'attributes' => ['onchange' => 'fetchEmployeeServices()'], // Trigger JavaScript to fetch services
        ]);

        CRUD::addField([
            'name' => 'services',  // You can optionally keep this field for reference
            'type' => 'text',
            'label' => 'Services Offered by Assigned Employee',
            'hint' => 'Automatically fetched from the assigned employee',
            'attributes' => ['readonly' => 'readonly'], // Make it read-only
            'wrapper' => ['class' => 'form-group col-md-6'],
        ]);

        CRUD::addField([
            'name' => 'schedule',
            'type' => 'datetime',
            'label' => 'Appointment Schedule',
        ]);

        // Add a script to fetch employee services on employee selection
        CRUD::addField([
            'type' => 'custom_html',
            'name' => 'custom_html',
            'value' => '<script>
                function fetchEmployeeServices() {
                    var employeeId = document.getElementById("employee_id").value;
                    if (employeeId) {
                        axios.get("/admin/employee/" + employeeId + "/services")
                            .then(function(response) {
                                document.getElementById("services").value = response.data.services.join(", ");
                            })
                            .catch(function(error) {
                                console.error("Error fetching services:", error);
                            });
                    } else {
                        document.getElementById("services").value = "";
                    }
                }
            </script>',
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
     * Define what happens when the Show operation is loaded.
     */
    protected function setupShowOperation()
    {
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
            'entity' => 'employee',
            'attribute' => 'name',
            'model' => 'App\Models\Employee',
        ]);

        CRUD::addColumn([
            'name' => 'schedule',
            'type' => 'datetime',
            'label' => 'Appointment Schedule',
        ]);
    }
}
