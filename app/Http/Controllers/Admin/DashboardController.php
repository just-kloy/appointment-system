<?php

namespace App\Http\Controllers\Admin;

use App\Models\CalendarEvent;
use Illuminate\Support\Facades\DB;  // Add this line to use DB facade
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Container\Attributes\Database;
use Illuminate\Http\Request;
use Backpack\CRUD\app\Library\Widget;
use App\Models\Client;
use App\Models\Employee;
use App\Models\Schedule;

class DashboardController extends CrudController
{
    public function index()
    {
        // Query to get the day of the week and count of schedules
        $weeklySchedules = DB::table('calendar_events')
            ->select(DB::raw('strftime("%w", schedule) as day_of_week, count(*) as total'))
            ->groupBy(DB::raw('strftime("%w", schedule)'))
            ->get();

        // Day names mapping for easy display
        $dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        // Get the total count of clients
        $clientsCount = Client::count();

        // Get the total count of employees (assuming you have an 'employees' table)
        $employeesCount = DB::table('employees')->count();

        // Pass data to the view
        return view('vendor.backpack.dashboard', compact('weeklySchedules', 'dayNames', 'clientsCount', 'employeesCount'));
    }
}
