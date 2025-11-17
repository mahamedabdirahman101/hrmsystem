<?php
include('authentication.php');
include('assets/includes/header.php');
include('assets/includes/sideForAdmin.php');
include('assets/includes/topbar.php');

if (!isset($_GET['staff_id'])) {
    echo "<div class='alert alert-danger m-3'>No staff selected. <a href='staff.php'>Go back</a></div>";
    include('assets/includes/footer.php');
    include('assets/includes/script.php');
    exit();
}

$staff_id = mysqli_real_escape_string($con, $_GET['staff_id']);
$staff_query = "SELECT * FROM `staff` WHERE `id`='$staff_id' LIMIT 1";
$staff_result = mysqli_query($con, $staff_query);
$staff_info = mysqli_fetch_assoc($staff_result);
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Staff Profile</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <!-- Profile Sidebar -->
                <div class="col-md-3">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile text-center">
                            <img class="profile-user-img img-fluid img-circle" 
                                 src="uploads/staff/<?= $staff_info['photo'] ?: 'default.png'; ?>" 
                                 alt="Profile picture">
                            <h3 class="profile-username"><?= $staff_info['title'] . " " . $staff_info['name']; ?></h3>
                            <p class="text-muted"><?= $staff_info['position']; ?></p>
                        </div>
                    </div>

                    <div class="card card-primary">
                        <div class="card-header"><h3 class="card-title">About</h3></div>
                        <div class="card-body">
                            <strong><i class="fas fa-book mr-1"></i> Education</strong>
                            <p class="text-muted"><?= $staff_info['education']; ?></p>
                            <hr>
                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Address</strong>
                            <p class="text-muted"><?= $staff_info['address']; ?></p>
                            <hr>
                            <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>
                            <p class="text-muted"><?= $staff_info['skills']; ?></p>

                            <?php if (!empty($staff_info['documents'])): ?>
                                <hr>
                                <a href="uploads/docs/<?= htmlspecialchars($staff_info['documents']); ?>" 
                                   target="_blank" class="btn btn-success btn-block">
                                   <i class="fa fa-file-pdf-o"></i> View CV
                                </a>
                            <?php else: ?>
                                <hr>
                                <div class="alert alert-warning">No CV uploaded.</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Profile Details + Records -->
                <div class="col-md-9">
                    <!-- Personal Details -->
                    <div class="card card-info mb-3">
                        <div class="card-header"><h3 class="card-title">Details</h3></div>
                        <div class="card-body">
                            <ul class="fa-ul">
                                <li><span class="fa-li"><i class="fas fa-building"></i></span>Department: <?= $staff_info['department']; ?></li>
                                <li><span class="fa-li"><i class="fas fa-user"></i></span>Position: <?= $staff_info['position']; ?></li>
                                <li><span class="fa-li"><i class="fas fa-phone"></i></span>Phone: <?= $staff_info['phone']; ?></li>
                                <li><span class="fa-li"><i class="fas fa-venus-mars"></i></span>Gender: <?= $staff_info['gender']; ?></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Leave & Discipline Records -->
                    <div class="row">
                        <!-- Leave -->
                        <div class="col-md-6">
                            <div class="card card-success mb-3">
                                <div class="card-header"><h3 class="card-title">Leave Records</h3></div>
                                <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                                    <?php
                                    $leave_query = "SELECT * FROM `approved_leaves` WHERE `staff_id` = '$staff_id'";
                                    $leave_result = mysqli_query($con, $leave_query);

                                    if ($leave_result && mysqli_num_rows($leave_result) > 0) {
                                        while ($leave = mysqli_fetch_assoc($leave_result)) {
                                            echo "<div class='mb-2 p-2 border rounded'>";
                                            echo "<strong>Type:</strong> {$leave['leave_type']}<br>";
                                            echo "<strong>From:</strong> {$leave['start_date']}<br>";
                                            echo "<strong>To:</strong> {$leave['end_date']}<br>";
                                            echo "<strong>Status:</strong> <span class='badge bg-info'>{$leave['status']}</span>";
                                            echo "</div>";
                                        }
                                    } else {
                                        echo "<div class='alert alert-info'>No leave records found for this staff member.</div>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <!-- Discipline -->
                        <div class="col-md-6">
                            <div class="card card-danger mb-3">
                                <div class="card-header"><h3 class="card-title">Discipline Records</h3></div>
                                <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                                    <?php
                                    $disc_query = "SELECT * FROM `discipline_records` WHERE `staff_id` = '$staff_id'";
                                    $disc_result = mysqli_query($con, $disc_query);

                                    if ($disc_result && mysqli_num_rows($disc_result) > 0) {
                                        while ($record = mysqli_fetch_assoc($disc_result)) {
                                            echo "<div class='mb-2 p-2 border rounded'>";
                                            echo "<strong>Offense:</strong> {$record['offense_type']}<br>";
                                            echo "<strong>Date:</strong> {$record['date_reported']}<br>";
                                            echo "<strong>Action Taken:</strong> {$record['action_taken']}";
                                            echo "</div>";
                                        }
                                    } else {
                                        echo "<div class='alert alert-info'>No discipline records found.</div>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Attendance Summary -->
                    <?php 
                    $percentage = 0;
                    $present = 0;
                    $totalDays = 0;

                    $query = "SELECT percentage, present_days, total_days FROM attendance_summary WHERE staff_id = '$staff_id' LIMIT 1";
                    $result = mysqli_query($con, $query);

                    if ($row = mysqli_fetch_assoc($result)) {
                        $percentage = round((float)$row['percentage'], 2);
                        $present = (int)$row['present_days'];
                        $totalDays = (int)$row['total_days'];
                    }
                    ?>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary mb-3">
                                <div class="card-header"><h3 class="card-title">Attendance Summary</h3></div>
                                <div class="card-body text-center">
                                    <div class="row justify-content-center">
                                        <div class="col-md-4">
                                            <canvas id="attendancePercentageChart" height="200"></canvas>
                                        </div>
                                    </div>
                                    <h4 class="mt-3"><?= $percentage ?>%</h4>
                                    <p class="text-muted">of days present (<?= $present ?>/<?= $totalDays ?>)</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Performance Table with Colored Badges
<div class="card card-warning mb-3">
    <div class="card-header">
        <h3 class="card-title">Performance Reviews</h3>
    </div>
    <div class="card-body table-responsive p-0" style="max-height: 300px;">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>Review Period</th>
                    <th>Score</th>
                    <th>Remarks</th>
                    <th>Review Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $perf_query = "SELECT * FROM performance_records WHERE staff_id = '$staff_id' ORDER BY review_date DESC";
                $perf_result = mysqli_query($con, $perf_query);

                if ($perf_result && mysqli_num_rows($perf_result) > 0) {
                    while ($perf = mysqli_fetch_assoc($perf_result)) {
                        $score = $perf['score'];
                        $badge_class = '';

                        if ($score >= 85) {
                            $badge_class = 'badge bg-success';
                        } elseif ($score >= 70) {
                            $badge_class = 'badge bg-warning';
                        } else {
                            $badge_class = 'badge bg-danger';
                        }

                        echo "<tr>";
                        echo "<td>{$perf['review_period']}</td>";
                        echo "<td><span class='{$badge_class}'>{$score}%</span></td>";
                        echo "<td>{$perf['remarks']}</td>";
                        echo "<td>{$perf['review_date']}</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center'>No performance records found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
 -->

                </div> <!-- end of col-md-9 -->

                
            </div>
        </div>
    </section>
</div>

<?php include('assets/includes/footer.php'); ?>
<?php include('assets/includes/script.php'); ?>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById("attendancePercentageChart").getContext("2d");

    new Chart(ctx, {
        type: "doughnut",
        data: {
            labels: ["Present", "Absent"],
            datasets: [{
                data: [<?= $percentage ?>, <?= 100 - $percentage ?>],
                backgroundColor: ["#28a745", "#e9ecef"],
                borderWidth: 1
            }]
        },
        options: {
            cutout: "75%",
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: { enabled: false }
            }
        }
    });

    const menuItem = document.querySelector(".nav-link[href='staff.php']");
    if (menuItem) {
        menuItem.classList.add("active");
    }
});
</script>
