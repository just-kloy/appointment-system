@extends(backpack_view('blank'))

@section('content')
    <div class="row">
        <!-- Total Clients Chart -->
        <div class="col-md-6">
            <canvas id="totalClientsChart" width="200" height="50"></canvas>
        </div>

        <!-- Total Employees Chart -->
        <div class="col-md-6">
            <canvas id="totalEmployeesChart" width="200" height="50"></canvas>
        </div>

        <!-- Weekly Schedules Chart -->
        <div class="col-md-12">
            <canvas id="weeklySchedulesChart" width="400" height="200"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Total Clients Chart
        var ctxClients = document.getElementById('totalClientsChart').getContext('2d');
        var totalClientsChart = new Chart(ctxClients, {
            type: 'pie',
            data: {
                labels: ['Clients'],
                datasets: [{
                    label: 'Total Clients',
                    data: [{{ $clientsCount }}],  // Pass the clients count from controller
                    backgroundColor: ['rgba(75, 192, 192, 0.2)'],
                    borderColor: ['rgba(75, 192, 192, 1)'],
                    borderWidth: 1
                }]
            }
        });

        // Total Employees Chart
        var ctxEmployees = document.getElementById('totalEmployeesChart').getContext('2d');
        var totalEmployeesChart = new Chart(ctxEmployees, {
            type: 'pie',
            data: {
                labels: ['Employees'],
                datasets: [{
                    label: 'Total Employees',
                    data: [{{ $employeesCount }}],  // Pass the employees count from controller
                    backgroundColor: ['rgba(255, 99, 132, 0.2)'],
                    borderColor: ['rgba(255, 99, 132, 1)'],
                    borderWidth: 1
                }]
            }
        });

        // Weekly Schedules Chart
        var ctxSchedules = document.getElementById('weeklySchedulesChart').getContext('2d');
        var weeklySchedulesChart = new Chart(ctxSchedules, {
            type: 'bar',
            data: {
                labels: @json($dayNames),  // Pass the day names array from controller
                datasets: [{
                    label: 'Schedules for the Week',
                    data: [
                        @foreach($weeklySchedules as $schedule)
                            {{ $schedule->total }},
                        @endforeach
                    ],
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            }
        });
    </script>
@endsection
