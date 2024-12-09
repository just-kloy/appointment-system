<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use CrudTrait;
    protected $fillable = ['name', 'contact_number', 'employee_id', 'services', 'schedule'];

    protected $casts = [
        'services' => 'array', // Cast services as an array
        'schedule' => 'datetime',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
}
}
