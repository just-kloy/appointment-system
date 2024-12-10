<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use CrudTrait;
    
    protected $fillable = [
        'name',
     'contact_number',
      'service_name',
       'amount',
    ];

    protected $casts = [
        'services' => 'array', // Cast services as an array
    ];
}
