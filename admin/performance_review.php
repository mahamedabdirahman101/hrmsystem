<?php
include('authentication.php');
include('assets/includes/header.php');
include('config/dbcon.php');
include('assets/includes/sideForAdmin.php');
include('assets/includes/topbar.php');

$user = $_SESSION['auth_user'];
$isAdmin = ($user['user_role'] === 'admin'); 
$isUser = ($user['user_role'] === 'user'); 
$isViewer = ($user['user_role'] === 'viewer');
?>

<div class="content-wrapper">

<!-- Add Performance Modal -->
<div class="modal fade" id="AddStaffModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Performance Review</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>

      <form action="code.php" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="form-group">
            <label>Staff Name</label>
            <select name="staff_id" class="form-control" required>
              <option value="">Select Staff</option>
              <?php
              $staffs = mysqli_query($con, "SELECT id, name FROM staff");
              foreach ($staffs as $staff) {
                echo "<option value='".htmlspecialchars($staff['id'])."'>".htmlspecialchars($staff['name'])."</option>";
              }
              ?>
            </select>
          </div>

          <div class="form-group">
            <label>Review Period</label>
            <input type="text" name="reviewperiod" class="form-control" required>
          </div>

          <div class="form-group">
            <label>Score</label>
            <input type="number" name="score" min="0" class="form-control" required>
          </div>

          <div class="form-group">
            <label>Remarks</label>
            <input type="text" name="remarks" class="form-control" required>
          </div>

          <div class="form-group">
            <label>Review Date</label>
            <input type="date" name="review_date" class="form-control" required>
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="submit" name="addPerformance" class="btn btn-success btn-block">Save Performance</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Content Header -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6"><h1 class="m-0">Dashboard</h1></div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Performance Review</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container">
    <div class="row">
      <div class="col-md-12">

        <?php
        if (isset($_SESSION['status'])) {
          echo "<div class='alert alert-success'>".$_SESSION['status']."</div>";
          unset($_SESSION['status']);
        }
        if (isset($_SESSION['alert'])) {
          echo "<div class='alert alert-warning'>".$_SESSION['alert']."</div>";
          unset($_SESSION['alert']);
        }
        ?>

        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Performance Review</h3>
            <?php if ($isAdmin || $isUser): ?>
              <a href="#" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#AddStaffModal">Add Performance</a>
            <?php endif; ?>
          </div>

          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Staff Name</th>
                  <th>Review Period</th>
                  <th>Score</th>
                  <th>Remarks</th>
                  <th>Review Date</th>
                  <?php if ($isAdmin || $isUser || $isViewer): ?>
                    <th>Action</th>
                  <?php endif; ?>
                </tr>
              </thead>
              <tbody>
                <?php
                $query = "SELECT performance_records.*, staff.name 
                          FROM performance_records 
                          JOIN staff ON staff.id = performance_records.staff_id 
                          ORDER BY performance_records.id DESC";
                $query_run = mysqli_query($con, $query);

                if (mysqli_num_rows($query_run) > 0) {
                  foreach ($query_run as $row) {
                    $score = (int)$row['score'];
                    $badgeClass = ($score >= 85) ? 'badge bg-success' : (($score >= 70) ? 'badge bg-warning' : 'badge bg-danger');
                    ?>
                    <tr>
                      <td><?= htmlspecialchars($row['name']); ?></td>
                      <td><?= htmlspecialchars($row['review_period']); ?></td>
                      <td><span class="<?= $badgeClass; ?>"><?= htmlspecialchars($row['score']); ?>%</span></td>
                      <td><?= htmlspecialchars($row['remarks']); ?></td>
                      <td><?= htmlspecialchars($row['review_date']); ?></td>
                      <td>
                        <?php if ($isAdmin || $isUser): ?>
                          <a href="attendance-edit.php?staff_id=<?= $row['id']; ?>" class="btn btn-sm btn-info"><i class="fa fa-edit"></i> Edit</a>
                          <a href="staffProfile.php?staff_id=<?= $row['staff_id']; ?>" class="btn btn-sm btn-success"><i class="fa fa-eye"></i> View Profile</a>
                        <?php elseif ($isViewer): ?>
                          <a href="staffProfile.php?staff_id=<?= $row['staff_id']; ?>" class="btn btn-sm btn-success"><i class="fa fa-eye"></i> View Profile</a>
                        <?php endif; ?>
                      </td>
                    </tr>
                    <?php
                  }
                } else {
                  echo "<tr><td colspan='7' class='text-center'>No Records Found</td></tr>";
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

<?php include('assets/includes/script.php'); ?>
<?php include('assets/includes/footer.php'); ?>
