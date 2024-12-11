@extends(backpack_view('blank'))

@section('content')
    <div class="row">
        <!-- Combined Clients and Employees Bar Chart -->
        <div class="col-md-12">
            <canvas id="clientsEmployeesChart" width="400" height="200"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Combined Clients and Employees Bar Chart
        var ctx = document.getElementById('clientsEmployeesChart').getContext('2d');
        var clientsEmployeesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['', ' '], // Labels for the two bars
                datasets: [
                    {
                        label: 'Total Clients',
                        data: [{{ $clientsCount }}], // Pass the clients count from controller
                        backgroundColor: ['rgba(75, 192, 192, 0.5)'], // Color for Clients
                        borderColor: ['rgba(75, 192, 192, 1)'], // Border color for Clients
                        borderWidth: 1
                    },
                    {
                        label: 'Total Employees',
                        data: [{{ $employeesCount }}], // Pass the employees count from controller
                        backgroundColor: ['rgba(255, 99, 132, 0.5)'], // Color for Employees
                        borderColor: ['rgba(255, 99, 132, 1)'], // Border color for Employees
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection