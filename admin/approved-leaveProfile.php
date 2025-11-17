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
          <h1>Approved Leave Profile</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Approved Leave Profile</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <!-- Main Content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image Card -->
          <div class="card card-primary card-outline">
            <?php
            if (isset($_GET['leave_id'])) {
              $leave_id = $_GET['leave_id'];
              $query = "SELECT al.*, s.name, s.department 
                        FROM approved_leaves al 
                        JOIN staff s ON s.id = al.staff_id 
                        WHERE al.leave_id='$leave_id' 
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
                    <b>Status</b> <span class="float-right badge badge-success"><?= $leave_info['status']; ?></span>
                  </li>
                </ul>
              </div>
            <?php } else {
              echo "<div class='p-3 text-danger'>No leave found!</div>";
            } ?>
          </div>

        </div>

        <!-- Right Content -->
        <div class="col-md-9">
          <div class="card">
            <div class="card-header">
               <a href="export-leave-pdf.php?leave_id=<?= $leave_info['leave_id']; ?>" class="btn btn-sm btn-warning float-right" target="_blank">
  <i class="fa fa-file-pdf-o"></i> Export as PDF
</a>&nbsp;
              <a href="approved.php" class="btn btn-danger btn-sm float-right">Back</a>

             
              <h3 class="card-title">Leave Details</h3>
            </div>
            <div class="card-body">

              <strong><i class="fas fa-calendar-day mr-1"></i> Days Left</strong>
              <p class="text-muted">
                <?php
                $today = new DateTime();
                $end = new DateTime($leave_info['end_date']);
                $interval = $today->diff($end);
                echo ($end < $today) ? "Leave has ended" : $interval->days . " day(s) remaining";
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
      </div>
    </div>
  </section>
</div>

<?php 
            }

?>

<?php include('assets/includes/footer.php'); ?>
<?php include('assets/includes/script.php'); ?>
