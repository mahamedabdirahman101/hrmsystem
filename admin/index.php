<?php
include('authentication.php');
include('assets/includes/header.php');
include('assets/includes/sideForAdmin.php');
include('assets/includes/topbar.php');
?>

<?php
$male_count = 0;
$female_count = 0;

$query = "SELECT gender, COUNT(*) as count FROM staff GROUP BY gender";
$result = mysqli_query($con, $query);
while ($row = mysqli_fetch_assoc($result)) {
    if (strtolower($row['gender']) === 'male') {
        $male_count = $row['count'];
    } elseif (strtolower($row['gender']) === 'female') {
        $female_count = $row['count'];
    }
}


$on_leave_count = 0;
$not_on_leave_count = 0;

// Count how many staff are on leave from approved_leaves table
$query = "SELECT COUNT(DISTINCT staff_id) as count FROM approved_leaves WHERE CURDATE() BETWEEN start_date AND end_date";
$result = mysqli_query($con, $query);
if ($row = mysqli_fetch_assoc($result)) {
    $on_leave_count = $row['count'];
}

// Get total staff and subtract to find non-leave
$query = "SELECT COUNT(*) as total FROM staff";
$result = mysqli_query($con, $query);
if ($row = mysqli_fetch_assoc($result)) {
    $total_staff = $row['total'];
    $not_on_leave_count = $total_staff - $on_leave_count;
}

?>


 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
     

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-md-12">
            <?php 
              include('message.php');
              

            ?>
          </div>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
              <?php 
              // SELECT COUNT(DISTINCT department_id) AS num_departments
              // FROM your_table
                $query = "SELECT COUNT(DISTINCT id) AS num_departments FROM `departments`;";
                $result = mysqli_query($con, $query);
                
                if ($result) {
                    $row = mysqli_fetch_assoc($result);
                    $num_departments = $row['num_departments'];
                } else {
                    $num_departments = 0; // Handle errors or empty result
                }


               
          
                              
                              
                    
                                  ?>
                                    <h3><?php echo $num_departments; ?><sup style="font-size: 20px"></sup></h3>

                <p>Departments</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="departments.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
         <div class="col-lg-3 col-6">
  <!-- small box -->
  <div class="small-box bg-success">
    <div class="inner">
      <?php 
      $query = "SELECT COUNT(id) AS total_staffs FROM staff";
      $result = mysqli_query($con, $query);

      $total_staffs = 0;
      if ($result && mysqli_num_rows($result) > 0) {
          $row = mysqli_fetch_assoc($result);
          $total_staffs = $row['total_staffs'] ?? 0;
      }
      ?>
      <h3><?php echo $total_staffs; ?><sup style="font-size: 20px"></sup></h3>
      <p>Total Staff</p>
    </div>
    <div class="icon">
      <i class="ion ion-stats-bars"></i>
    </div>
    <a href="staff.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
  </div>
</div>

          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
              <?php 
              // SELECT COUNT(DISTINCT department_id) AS num_departments
              // FROM your_table
                $query = "SELECT COUNT(DISTINCT id) AS num_users FROM `users`;";
                $result = mysqli_query($con, $query);
                
                if ($result) {
                    $row = mysqli_fetch_assoc($result);
                    $num_users = $row['num_users'];
                } else {
                    $num_users = 0; // Handle errors or empty result
                }


               
          
                              
                              
                    
                                  ?>
                                    <h3><?php echo $num_users; ?><sup style="font-size: 20px"></sup></h3>


                <p>User Registrations</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="registered.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
         <div class="col-lg-3 col-6">
  <div class="small-box bg-danger">
    <div class="inner">
      <?php
      $today = date('Y-m-d');
      $tenDaysLater = date('Y-m-d', strtotime('+10 days'));

      $query = "SELECT COUNT(leave_id) AS num_expired_leaves 
                FROM `approved_leaves` 
                WHERE end_date BETWEEN '$today' AND '$tenDaysLater'";

      $result = mysqli_query($con, $query);
      $total_on_leave = 0;

      if ($result && mysqli_num_rows($result) > 0) {
          $row = mysqli_fetch_assoc($result);
          $total_on_leave = $row['num_expired_leaves'] ?? 0;
      }
      ?>
      <h3><?= $total_on_leave ?></h3>
      <p>Leaves Expiring in 10 Days</p>
    </div>
    <div class="icon">
      <i class="ion ion-clock"></i>
    </div>
    <a href="approvedLeave.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
  </div>
</div>


        </div>
        

<div class="row">
  <!-- Gender Donut Chart -->
  <div class="col-md-6">
    <div class="card card-success">
      <div class="card-header">
        <h3 class="card-title">Gender Distribution</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool" data-card-widget="remove">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="chart">
          <canvas id="genderDonutChart" style="min-height: 250px; height: 250px;"></canvas>
        </div>
      </div>
    </div>
  </div>

  <!-- Leave Donut Chart -->
  <div class="col-md-6">
    <div class="card card-success">
      <div class="card-header">
        <h3 class="card-title">Leave Report</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool" data-card-widget="remove">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="chart">
          <canvas id="leaveDonutChart" style="min-height: 250px; height: 250px;"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

            <!-- /.card -->
        </div><!-- /.container-fluid -->
    </section>
</div>
<?php include('assets/includes/footer.php'); ?>
<?php include('assets/includes/script.php'); ?>
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  var ctx = document.getElementById('barChart').getContext('2d');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Male', 'Female'],
      datasets: [{
        label: 'Staff Count',
        data: [<?= $maleCount ?>, <?= $femaleCount ?>],
        backgroundColor: ['#007bff', '#e83e8c']
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true,
          ticks: { stepSize: 1 }
        }
      }
    }
  });
});
</script>

<script>
  $(function () {
    const ctx = document.getElementById('genderDonutChart').getContext('2d');
    const genderDonutChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: ['Male', 'Female'],
        datasets: [{
          data: [<?= $male_count ?>, <?= $female_count ?>],
          backgroundColor: ['#007bff', '#dc3545'],
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'right'
          }
        }
      }
    });
  });
</script>

<script>
  $(function () {
    const ctx = document.getElementById('leaveDonutChart').getContext('2d');
    const leaveDonutChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: ['On Leave', 'Not on Leave'],
        datasets: [{
          data: [<?= $on_leave_count ?>, <?= $not_on_leave_count ?>],
          backgroundColor: ['#ffc107', '#28a745'],
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'right'
          }
        }
      }
    });
  });
</script>

