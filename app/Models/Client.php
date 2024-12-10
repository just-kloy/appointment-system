<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use CrudTrait;
    protected $fillable = [
        'name',
        'contact_number', 
        'employee_id', 
        'schedule',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function getEmployeeServices()
    {
        return $this->employee ? $this->employee->services : [];
    }
}
