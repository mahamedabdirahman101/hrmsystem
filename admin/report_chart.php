<?php
require 'dbcon.php';

// Example: Fetch number of leaves by status
$query = "SELECT status, COUNT(*) as count FROM leaves GROUP BY status";
$result = mysqli_query($con, $query);

$statuses = [];
$counts = [];

while ($row = mysqli_fetch_assoc($result)) {
    $statuses[] = $row['status'];
    $counts[] = $row['count'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Leave Report Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h2>Leave Report by Status</h2>
    <canvas id="statusChart" width="400" height="200"></canvas>

    <script>
        const ctx = document.getElementById('statusChart').getContext('2d');
        const statusChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($statuses); ?>,
                datasets: [{
                    label: 'Leave Count',
                    data: <?php echo json_encode($counts); ?>,
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(255, 99, 132, 0.6)'
                    ],
                    borderColor: 'rgba(255, 255, 255, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
</body>
</html>
