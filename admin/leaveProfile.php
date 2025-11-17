<?php
include('authentication.php');
include('assets/includes/header.php');
include('assets/includes/sideForAdmin.php');
include('assets/includes/topbar.php');
include('config/dbcon.php');
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Leave Profile</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Leave Profile</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="card card-primary card-outline">
            <?php
            if (isset($_GET['leave_id'])) {
              $leave_id = $_GET['leave_id'];
              $query = "SELECT l.*, s.name, s.department FROM `leave` l JOIN staff s ON s.id = l.staff_id WHERE l.leave_id='$leave_id' LIMIT 1";
              $query_run = mysqli_query($con, $query);

              if (mysqli_num_rows($query_run) > 0) {
                foreach ($query_run as $staff_info) {
            ?>

            <div class="card-body box-profile">
              <h3 class="profile-username text-center">
                <p class="text-muted text-center"><?= $staff_info['department']; ?></p>
                <?= $staff_info['name']; ?>
              </h3>

              <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                  <b>Department</b> <a class="float-right"><?= $staff_info['department']; ?></a>
                </li>
                <li class="list-group-item">
                  <b>Leave Type</b> <a class="float-right"><?= $staff_info['leave_type']; ?></a>
                </li>
              </ul>
            </div>
          </div>

          <div class="card card-primary">
            <?php
            $user = $_SESSION['auth_user'];
            $isAdmin = ($user['user_role'] === 'admin');
            $isUser = ($user['user_role'] === 'user');
            ?>

            <?php if ($isUser || $isAdmin): ?>
              <a href="leave-edit.php?leave_id=<?= $staff_info['leave_id']; ?>" class="btn btn-sm btn-info m-2">
                <i class="fa fa-edit"></i> Edit
              </a>
            <?php endif; ?>
          </div>
        </div>

        <div class="col-md-9">
          <div class="card">
            <div class="card-header p-2">
              <a href="leave.php" class="btn btn-danger btn-sm float-right">Back</a>
            </div>

            <div class="card-body">
              <strong><i class="fas fa-calendar-day mr-1"></i> Days Left</strong>
              <p class="text-muted">
                <?php
                $today = new DateTime();
                $end = new DateTime($staff_info['end_date']);
                $interval = $today->diff($end);
                echo ($end < $today) ? "Leave has ended" : $interval->days . " days remaining";
                ?>
              </p>

              <hr>

              <strong><i class="fas fa-clipboard mr-1"></i> Leave Type</strong>
              <p class="text-muted"><?= $staff_info['leave_type']; ?></p>

              <hr>

              <strong><i class="fas fa-calendar-alt mr-1"></i> Start Date</strong>
              <p class="text-muted"><?= $staff_info['start_date']; ?></p>

              <hr>

              <strong><i class="fas fa-calendar-check mr-1"></i> End Date</strong>
              <p class="text-muted"><?= $staff_info['end_date']; ?></p>

              <hr>

              <strong><i class="fas fa-info-circle mr-1"></i> Status</strong>
              <p class="text-muted"><?= $staff_info['status']; ?></p>

              <?php if ($isAdmin): ?>
                <div class="float-right">
                  <a href="leave-edit.php?leave_id=<?= $staff_info['leave_id']; ?>" class="btn btn-primary">
                    <i class="fa fa-check"></i> Approve
                  </a>
                </div>
              <?php endif; ?>

            </div>
          </div>
        </div>

      </div>
    </div>
  </section>
</div>

<?php
                }
              }
            }
?>

<?php include('assets/includes/footer.php'); ?>
<?php include('assets/includes/script.php'); ?>
