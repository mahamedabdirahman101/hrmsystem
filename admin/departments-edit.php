<?php
include('authentication.php');
include('assets/includes/header.php');
include('assets/includes/sideForAdmin.php');
include('config/dbcon.php');
include('assets/includes/topbar.php');
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

<?php
if (isset($_GET['dept_id'])) {
    $dept_id = $_GET['dept_id'];
    $query = "SELECT * FROM `departments` WHERE id='$dept_id'";
    $query_run = mysqli_query($con, $query);

    if (mysqli_num_rows($query_run) > 0) {
        $deptItem = mysqli_fetch_array($query_run);
?>

<section class="content mt-4">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <?php include('message.php'); ?>
        <div class="card">
          <div class="card-header">
            <h4>Department - EDIT
              <a href="departments.php" class="btn btn-secondary float-right">BACK</a>
            </h4>
          </div>

          <div class="card-body">
            <form action="code.php" method="POST">
              <input type="hidden" name="dept_id" value="<?= $deptItem['id'] ?>">

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Department Name</label>
                    <input type="text" name="name" class="form-control" value="<?= $deptItem['name']; ?>" required>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Department Category</label>
                    <select name="category" class="form-control" required>
                      <option value="">Select category</option>
                      <option value="Main" <?= $deptItem['category'] === 'Main' ? 'selected' : '' ?>>Main</option>
                      <option value="Supportive" <?= $deptItem['category'] === 'Supportive' ? 'selected' : '' ?>>Supportive</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Director</label>
                    <input type="text" name="director" class="form-control" value="<?= $deptItem['director']; ?>" required>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label>Overview</label>
                    <textarea name="overview" class="form-control" rows="4" required><?= $deptItem['overview']; ?></textarea>
                  </div>
                </div>

                <div class="col-md-6">
                  <button type="submit" name="updateDepts" class="btn btn-primary btn-block">Update</button>
                </div>

                <div class="col-md-6">
                  <button type="button" value="<?= $deptItem['id']; ?>" class="btn btn-danger btn-block deleteDeptbtn">
                    <i class="fa fa-trash"></i> Delete
                  </button>
                </div>
              </div>
            </form>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>

<!-- Delete Modal -->
<div class="modal fade" id="DeleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form action="code.php" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Delete Department</h5>
          <button type="button" class="btn-close" data-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="delete_dept" class="delete_dept_id">
          <p>Are you sure you want to delete this department?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" name="DeleteDepartment" class="btn btn-danger">Yes, Delete</button>
        </div>
      </div>
    </form>
  </div>
</div>

<?php
    } else {
        echo "<div class='alert alert-warning'>No Such Department Found</div>";
    }
}
?>

</div>

<?php include('assets/includes/script.php'); ?>

<script>
  $(document).ready(function () {
    $('.deleteDeptbtn').click(function () {
      var deptid = $(this).val();
      $('.delete_dept_id').val(deptid);
      $('#DeleteModal').modal('show');
    });
  });
</script>

<?php include('assets/includes/footer.php'); ?>
