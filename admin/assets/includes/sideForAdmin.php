<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = "localhost";
$username = "root";
$password = "";
$database = "phpadminpanel";

$con = mysqli_connect($host, $username, $password, $database);

if (!$con) {
    header("Location: ../errors/db.php");
    exit();
}

if (!isset($_SESSION['auth'])) {
    $_SESSION['auth_status'] = "Login to Access Dashboard";
    header('Location: login.php');
    exit();
}

// Get user information from session
$user = $_SESSION['auth_user'] ?? null;

$isAdmin = false;
$isUser = false;
$isViewer = false;

if ($user && isset($user['user_role'])) {
    $role = strtolower($user['user_role']);
    $isAdmin = $role === 'admin';
    $isUser = $role === 'user';
    $isViewer = $role === 'viewer';
}
?>


<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-warning elevation-2">
  <!-- Brand Logo -->
  <a href="index.php" class="brand-link">
    <img src="assets/dist/img/logo.jpg" alt="Logo" class="brand-image img-circle elevation-3">
    <span class="brand-text font-weight-light">Employee MS</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar Search -->
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

        <!-- Department -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-building"></i>
            <p>Department <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <?php if ($isAdmin): ?>
              <li class="nav-item">
                <a href="departments.php" class="nav-link">
                  <i class="fas fa-cogs nav-icon"></i>
                  <p>Manage Departments</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="departments.php" class="nav-link">
                  <i class="fas fa-plus-circle nav-icon"></i>
                  <p>Add Department</p>
                </a>
              </li>
            <?php elseif ($isUser || $isViewer): ?>
              <li class="nav-item">
                <a href="departments.php" class="nav-link">
                  <i class="fas fa-eye nav-icon"></i>
                  <p>View Departments</p>
                </a>
              </li>
            <?php endif; ?>
          </ul>
        </li>

        <!-- Staff -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-id-badge"></i>
            <p>Staff <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <?php if ($isAdmin): ?>
              <li class="nav-item">
                <a href="staff.php" class="nav-link">
                  <i class="fas fa-cogs nav-icon"></i>
                  <p>Manage Staff</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="staff.php" class="nav-link">
                  <i class="fas fa-plus-circle nav-icon"></i>
                  <p>Add Staff</p>
                </a>
              </li>
            <?php elseif ($isUser || $isViewer): ?>
              <li class="nav-item">
                <a href="staff.php" class="nav-link">
                  <i class="fas fa-eye nav-icon"></i>
                  <p>View Staff</p>
                </a>
              </li>
            <?php endif; ?>
          </ul>
        </li>

         <!-- Attendance -->
        <li class="nav-item has-treeview">
  <a href="#" class="nav-link">
    <i class="nav-icon fas fa-user-check"></i>
    <p>Attendance <i class="right fas fa-angle-left"></i></p>
  </a>

          <ul class="nav nav-treeview">
            <?php if ($isAdmin): ?>
              <li class="nav-item">
                <a href="attendance_summary.php" class="nav-link">
                 <i class="nav-icon fas fa-calendar-check"></i>
                  <p>Manage Attendance</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="attendance_summary.php" class="nav-link">
                  <i class="fas fa-plus-circle nav-icon"></i>
                  <p>Add Attendance</p>
                </a>
              </li>
            <?php elseif ($isUser || $isViewer): ?>
              <li class="nav-item">
                <a href="attendance_summary.php" class="nav-link">
                  <i class="fas fa-eye nav-icon"></i>
                  <p>View Attendance</p>
                </a>
              </li>
            <?php endif; ?>
          </ul>
        </li>


        <!-- Performance Review 
        <li class="nav-item has-treeview">
  <a href="performance_review.php" class="nav-link">
    <i class="nav-icon fas fa-user-check"></i>
    <p>Performance Review <i class="right fas fa-angle-left"></i></p>
  </a>

          <ul class="nav nav-treeview">
            <?php if ($isAdmin): ?>
              <li class="nav-item">
                <a href="performance_review.php" class="nav-link">
                 <i class="nav-icon fas fa-calendar-check"></i>
                  <p>Manage Performance</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="performance_review.php" class="nav-link">
                  <i class="fas fa-plus-circle nav-icon"></i>
                  <p>Add Performance</p>
                </a>
              </li>
            <?php elseif ($isUser || $isViewer): ?>
              <li class="nav-item">
                <a href="performance_review.php" class="nav-link">
                  <i class="fas fa-eye nav-icon"></i>
                  <p>View Performance</p>
                </a>
              </li>
            <?php endif; ?>
          </ul>
        </li>

-->

        <!-- Leave -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-handshake"></i>
            <p>Leave <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <?php if ($isAdmin): ?>
              <li class="nav-item">
                <a href="leave.php" class="nav-link">
                  <i class="fas fa-cogs nav-icon"></i>
                  <p>Manage Leave</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="leave.php" class="nav-link">
                  <i class="fas fa-plus-circle nav-icon"></i>
                  <p>Add Leave</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="approvedLeave.php" class="nav-link">
                  <i class="fas fa-check nav-icon"></i>
                  <p>Approved Leaves</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="cancelled.php" class="nav-link">
                  <i class="fas fa-ban nav-icon"></i>
                  <p>Cancelled Leaves</p>
                </a>
              </li>
            <?php elseif ($isUser): ?>
              <li class="nav-item">
                <a href="leave.php" class="nav-link">
                  <i class="fas fa-eye nav-icon"></i>
                  <p>View Leave</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="approvedLeave.php" class="nav-link">
                  <i class="fas fa-check nav-icon"></i>
                  <p>Approved Leaves</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="cancelled.php" class="nav-link">
                  <i class="fas fa-ban nav-icon"></i>
                  <p>Cancelled Leaves</p>
                </a>
              </li>
            <?php elseif ($isViewer): ?>
              <li class="nav-item">
                <a href="leave.php" class="nav-link">
                  <i class="fas fa-eye nav-icon"></i>
                  <p>View Leave</p>
                </a>
              </li>
            <?php endif; ?>
          </ul>
        </li>

        <!-- Discipline -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-gavel"></i>
            <p>Discipline <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <?php if ($isAdmin): ?>
              <li class="nav-item">
                <a href="discipline_records.php" class="nav-link">
                  <i class="fas fa-cogs nav-icon"></i>
                  <p>Manage Records</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="resolved_records.php" class="nav-link">
                  <i class="fas fa-check-circle nav-icon"></i>
                  <p>Resolved Records</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="discipline_records.php" class="nav-link">
                  <i class="fas fa-plus-circle nav-icon"></i>
                  <p>Add Record</p>
                </a>
              </li>
            <?php else: ?>
              <li class="nav-item">
                <a href="discipline_records.php" class="nav-link">
                  <i class="fas fa-eye nav-icon"></i>
                  <p>View Records</p>
                </a>
              </li>
            <?php endif; ?>
          </ul>
        </li>

        <!-- Settings -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-cog"></i>
            <p>Settings <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <?php if ($isAdmin): ?>
              <li class="nav-item">
                <a href="pages/calendar.html" class="nav-link">
                  <i class="far fa-user nav-icon"></i>
                  <p>Admin Profile</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="registered.php" class="nav-link">
                  <i class="fas fa-users nav-icon"></i>
                  <p>Registered Users</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/kanban.html" class="nav-link">
                  <i class="fas fa-user-tag nav-icon"></i>
                  <p>Role of User</p>
                </a>
              </li>
            <?php endif; ?>
          </ul>
        </li>

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
