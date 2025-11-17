<?php
include('authentication.php');
include('assets/includes/header.php');
include('config/dbcon.php');
include('assets/includes/sideForAdmin.php');
include('assets/includes/topbar.php');
?>

<!-- Content Wrapper -->
<div class="content-wrapper">

<!-- Add Department Modal -->
<div class="modal fade" id="AddDeptModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="code.php" method="POST">
        <div class="modal-header">
          <h5 class="modal-title">Add Department</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Department Name</label>
            <input type="text" name="name" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Department Category</label>
            <select name="category" class="form-control" required>
              <option value="">Select category</option>
              <option value="Main">Main</option>
              <option value="Supportive">Supportive</option>
            </select>
          </div>
          <div class="form-group">
            <label>Director</label>
            <input type="text" name="director" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Overview</label>
            <textarea name="overview" rows="3" class="form-control" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="addDepartment" class="btn btn-success btn-block">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="DeleteModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="code.php" method="POST">
        <div class="modal-header">
          <h5 class="modal-title">Delete Department</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="delete_dept" class="delete_dept_id">
          <p>Are you sure you want to delete this department?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" name="DeleteDepartment" class="btn btn-danger">Yes, Delete</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Page Header -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6"><h1 class="m-0">Departments</h1></div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Departments</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<!-- Main Content -->
<section class="content">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <?php include('message.php'); ?>

        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Registered Departments</h3>
            <?php
            $user = $_SESSION['auth_user'];
            if ($user['user_role'] === 'admin' || $user['user_role'] === 'user'): ?>
              <a href="#" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#AddDeptModal">Add Department</a>
            <?php endif; ?>
          </div>

          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Category</th>
                  <th>Staff Count</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $query = "SELECT * FROM departments";
                $query_run = mysqli_query($con, $query);

                if (mysqli_num_rows($query_run) > 0) {
                  foreach ($query_run as $row) {
                    $dept_name = mysqli_real_escape_string($con, $row['name']);
                    $count_query = "SELECT COUNT(*) AS staff_count FROM staff WHERE department = '$dept_name'";
                    $count_result = mysqli_query($con, $count_query);
                    $staff_count = ($count_result) ? mysqli_fetch_assoc($count_result)['staff_count'] : 0;
                ?>
                  <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= htmlspecialchars($row['name']); ?></td>
                    <td><?= htmlspecialchars($row['category']); ?></td>
                    <td><?= $staff_count; ?> Staff</td>
                    <td>
                      <a href="departments-edit.php?dept_id=<?= $row['id']; ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Edit</a>
                      <button type="button" value="<?= $row['id']; ?>" class="btn btn-danger btn-sm deletebtn"><i class="fa fa-trash"></i> Delete</button>
                      <a href="deptProfile.php?dept_id=<?= $row['id']; ?>" class="btn btn-success btn-sm"><i class="fa fa-eye"></i> View</a>
                    </td>
                  </tr>
                <?php
                  }
                } else {
                  echo "<tr><td colspan='5' class='text-center text-warning'>No departments found</td></tr>";
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
<script>
  $(document).ready(function () {
    $('.deletebtn').click(function () {
      var deptid = $(this).val();
      $('.delete_dept_id').val(deptid);
      $('#DeleteModal').modal('show');
    });
  });
</script>
<?php include('assets/includes/footer.php'); ?>
