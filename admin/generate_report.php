<?php
include('authentication.php');
include('assets/includes/header.php');
include('assets/includes/sideForAdmin.php');
include('config/dbcon.php');
include('assets/includes/topbar.php');

// Fetch department-wise leave counts
$query = "SELECT department, COUNT(*) AS total FROM leaves GROUP BY department";
$result = mysqli_query($con, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($con));
}

// Prepare data for Chart.js
$departments = [];
$leaveCounts = [];

while ($row = mysqli_fetch_assoc($result)) {
    $departments[] = $row['department'];
    $leaveCounts[] = $row['total'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Leave Report - Bar Graph</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h2>Leave Report (by Department)</h2>
    <canvas id="leaveChart" width="800" height="400"></canvas>

    <script>
        const ctx = document.getElementById('leaveChart').getContext('2d');

        const leaveChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($departments); ?>,
                datasets: [{
                    label: 'Number of Leaves',
                    data: <?php echo json_encode($leaveCounts); ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        stepSize: 1
                    }
                }
            }
        });
    </script>
</body>
</html>
