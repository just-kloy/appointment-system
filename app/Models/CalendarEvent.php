<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;


class CalendarEvent extends Model
{
    use CrudTrait;

    protected $fillable = [
        'client_id', 
        'schedule', 
    ];

    // Cast 'schedule' to datetime to ensure it's a Carbon instance
    protected $casts = [
        'schedule' => 'datetime', 
    ];

    // Define relationship with Client model
     public function calendarEvents()
    {
        return $this->hasMany(CalendarEvent::class);
    }


    // Get the event start time for the calendar view
    public function getStartTimeAttribute()
    {
        return $this->schedule->format('Y-m-d H:i:s');  // Ensure correct format for FullCalendar
    }

    // Get the event end time (adding 1 hour for example) for the calendar view
    public function getEndTimeAttribute()
    {
        return $this->schedule->addHour()->format('Y-m-d H:i:s');
    }
}
