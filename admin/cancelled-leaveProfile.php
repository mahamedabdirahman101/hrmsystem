<?php
include('authentication.php');
include('assets/includes/header.php');
include('assets/includes/sideForAdmin.php');
include('assets/includes/topbar.php');
include('config/dbcon.php');
?>

<!-- Content Wrapper -->
<div class="content-wrapper">

  <!-- Page Header -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Cancelled Leave Profile</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Cancelled Leave</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <!-- Main Content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- Left column -->
        <div class="col-md-3">

          <div class="card card-primary card-outline">
            <?php
            if (isset($_GET['leave_id'])) {
              $leave_id = $_GET['leave_id'];
              $query = "SELECT cl.*, s.name, s.department 
                        FROM cancelled_leaves cl 
                        JOIN staff s ON s.id = cl.staff_id 
                        WHERE cl.leave_id='$leave_id' 
                        LIMIT 1";
              $query_run = mysqli_query($con, $query);

              if (mysqli_num_rows($query_run) > 0) {
                $leave_info = mysqli_fetch_assoc($query_run);
            ?>
              <div class="card-body box-profile">
                <h3 class="profile-username text-center"><?= $leave_info['name']; ?></h3>
                <p class="text-muted text-center"><?= $leave_info['department']; ?></p>
                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Leave Type</b> <span class="float-right"><?= $leave_info['leave_type']; ?></span>
                  </li>
                  <li class="list-group-item">
                    <b>Status</b> <span class="float-right badge bg-danger"><?= $leave_info['status']; ?></span>
                  </li>
                </ul>
              </div>
            <?php } else {
              echo "<div class='p-3 text-danger'>No leave found!</div>";
            } ?>
          </div>

        </div>

        <!-- Right column -->
        <div class="col-md-9">
          <div class="card">
            <div class="card-header">

            <a href="export-cancelled-pdf.php?leave_id=<?= $leave_info['leave_id']; ?>" class="btn btn-sm btn-warning" target="_blank">
  <i class="fa fa-file-pdf-o"></i> Export as PDF
</a>

              <a href="cancelled.php" class="btn btn-danger btn-sm float-right">Back</a>
              <hr>
              <h3 class="card-title">Leave Details</h3>
            </div>
            <div class="card-body">

              <strong><i class="fas fa-calendar-day mr-1"></i> Days Between</strong>
              <p class="text-muted">
                <?php
                $start = new DateTime($leave_info['start_date']);
                $end = new DateTime($leave_info['end_date']);
                $interval = $start->diff($end);
                echo $interval->days . " day(s)";
                ?>
              </p>
              <hr>

              <strong><i class="fas fa-calendar-alt mr-1"></i> Start Date</strong>
              <p class="text-muted"><?= $leave_info['start_date']; ?></p>
              <hr>

              <strong><i class="fas fa-calendar-check mr-1"></i> End Date</strong>
              <p class="text-muted"><?= $leave_info['end_date']; ?></p>
              <hr>

              <strong><i class="fas fa-file-pdf mr-1"></i> Document</strong>
              <p class="text-muted">
                <?php if (!empty($leave_info['documents'])): ?>
                  <a href="uploads/leaveDocuments/<?= $leave_info['documents']; ?>" target="_blank" class="btn btn-sm btn-primary">
                    <i class="fa fa-eye"></i> View Document
                  </a>
                <?php else: ?>
                  No document uploaded.
                <?php endif; ?>
              </p>

            </div>
          </div>
        </div>
        <!-- /.col-md-9 -->
      </div>
    </div>
  </section>
</div>

<?php 
            } 
?>

<?php include('assets/includes/footer.php'); ?>
<?php include('assets/includes/script.php'); ?>
