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
        <h1>Cancelled Leaves</h1>
      </div>
    </div>
  </div>
</section>

<!-- Main Content -->
<section class="content">
  <div class="container">
    <div class="row">
      <div class="col-md-12">

        <?php
        if (isset($_SESSION['status'])) {
            echo "<h4 class='alert alert-success alert-dismissible fade show'>" . $_SESSION['status'] . "</h4>";
            unset($_SESSION['status']);
        }
        ?>

        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Cancelled Leave Records</h3>
          </div>
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>Leave ID</th>
                <th>Staff Name</th>
                <th>Leave Type</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Document</th>
                <th>Action</th>
              </tr>
              </thead>
              <tbody>

              <?php
              $query = "SELECT cl.*, s.name FROM cancelled_leaves cl
                        JOIN staff s ON s.id = cl.staff_id
                        ORDER BY cl.cancelled_at DESC";
              $query_run = mysqli_query($con, $query);

              if (mysqli_num_rows($query_run) > 0) {
                  foreach ($query_run as $row) {
                      ?>
                      <tr>
                        <td><?= $row['leave_id']; ?></td>
                        <td><?= $row['name']; ?></td>
                        <td><?= $row['leave_type']; ?></td>
                        <td><?= $row['start_date']; ?></td>
                        <td><?= $row['end_date']; ?></td>
                        <td><span class="badge bg-danger"><?= $row['status']; ?></span></td>
                        <td>
                          <?php if (!empty($row['documents'])): ?>
                            <a href="uploads/leaveDocuments/<?= $row['documents']; ?>" target="_blank" class="btn btn-sm btn-primary">
                              <i class="fa fa-file-pdf-o"></i> View
                            </a>
                          <?php else: ?>
                            <span class="text-muted">None</span>
                          <?php endif; ?>
                        </td>
                        <td>
                          <a href="cancelled-leaveProfile.php?leave_id=<?= $row['leave_id']; ?>" class="btn btn-sm btn-info">
  <i class="fa fa-eye"></i> View
</a>

                        </td>
                      </tr>
                      <?php
                  }
              } else {
                  echo "<tr><td colspan='8' class='text-center'>No cancelled leaves found.</td></tr>";
              }
              ?>

              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

</div>

<?php include('assets/includes/footer.php'); ?>
<?php include('assets/includes/script.php'); ?>
