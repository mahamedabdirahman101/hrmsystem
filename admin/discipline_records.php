<?php
include('authentication.php');
include('assets/includes/header.php');
include('assets/includes/sideForAdmin.php');
include('assets/includes/topbar.php');
include('config/dbcon.php');
?>

<div class="content-wrapper">

<!-- Add Record Modal -->
<div class="modal fade" id="AddRecordModal" tabindex="-1" aria-labelledby="AddRecordModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="code.php" method="POST">
        <div class="modal-header">
          <h5 class="modal-title">Add Record</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Staff Name</label>
            <select name="staff_id" class="form-control" required>
              <option value="">Select Staff</option>
              <?php
              $staffs = mysqli_query($con, "SELECT id, name FROM staff");
              foreach ($staffs as $staff) {
                echo "<option value='{$staff['id']}'>{$staff['name']}</option>";
              }
              ?>
            </select>
          </div>

          <div class="form-group">
            <label>Offense Type</label>
            <input type="text" name="offense_type" class="form-control" required>
          </div>

          <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control" required></textarea>
          </div>

          <div class="form-group">
            <label>Date Reported</label>
            <input type="date" name="date_reported" class="form-control" required>
          </div>

          <div class="form-group">
            <label>Action Taken</label>
            <select name="action_taken" class="form-control" required>
              <option value="Oral Warning 1">Oral Warning 1</option>
              <option value="Oral Warning 2">Oral Warning 2</option>
              <option value="Warning 1">Warning 1</option>
              <option value="Warning 2">Warning 2</option>
              <option value="Dismissal">Dismissal</option>
            </select>
          </div>

          <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control" required>
              <option value="Pending">Pending</option>
              <option value="Resolved">Resolved</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="save_discipline" class="btn btn-success">Save</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="DeleteModal" tabindex="-1" aria-labelledby="DeleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="code.php" method="POST">
        <div class="modal-header">
          <h5 class="modal-title">Delete Record</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <!-- Hidden input for deletion -->
<input type="hidden" name="delete_id" class="delete_user_id">

          <p>Are you sure you want to delete this record?</p>
        </div>
        <div class="modal-footer">
          <button type="submit" name="DeleteRecordbtn" class="btn btn-danger">Yes, Delete</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Content Header -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6"><h1 class="m-0">Discipline Records</h1></div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
          <li class="breadcrumb-item active">Records</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<!-- Main Content -->
<section class="content">
  <div class="container-fluid">
    <?php
    if (isset($_SESSION['status'])) {
      echo "<div class='alert alert-success'>{$_SESSION['status']}</div>";
      unset($_SESSION['status']);
    }

    if (isset($_SESSION['alert'])) {
      echo "<div class='alert alert-warning'>{$_SESSION['alert']}</div>";
      unset($_SESSION['alert']);
    }
    ?>

    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Record Management</h3>
        <?php if ($_SESSION['auth_user']['user_role'] !== 'viewer'): ?>
          <a href="#" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#AddRecordModal">Add Record</a>
        <?php endif; ?>
      </div>

      <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Staff</th>
              <th>Offense Type</th>
              <th>Date Reported</th>
              <th>Action Taken</th>
              <th>Recorded By</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $query = "
              SELECT dr.*, s.name AS staff_name
              FROM discipline_records dr
              JOIN staff s ON dr.staff_id = s.id
            ";
            $query_run = mysqli_query($con, $query);

            if (mysqli_num_rows($query_run) > 0):
              foreach ($query_run as $record):
            ?>
              <tr>
                <td><?= htmlspecialchars($record['staff_name']) ?></td>
                <td><?= htmlspecialchars($record['offense_type']) ?></td>
                <td><?= htmlspecialchars($record['date_reported']) ?></td>
                <td><?= htmlspecialchars($record['action_taken']) ?></td>
                <td><?= htmlspecialchars($record['recorded_by']) ?></td>
                <td><?= htmlspecialchars($record['status']) ?></td>
                <td>
                  <a href="recordProfile.php?id=<?= $record['id'] ?>" class="btn btn-sm btn-primary">View</a>

                  <?php if ($_SESSION['auth_user']['user_role'] !== 'viewer'): ?>
                    <a href="record-edit.php?id=<?= $record['id'] ?>" class="btn btn-sm btn-info"><i class="fa fa-edit"></i> Edit</a>
                    <!-- Inside your table row loop -->
<button type="button" value="<?= $record['id'] ?>" class="btn btn-sm btn-danger deletebtn">
    <i class="fa fa-trash"></i> Delete
</button>

                  <?php endif; ?>
                </td>
              </tr>
            <?php
              endforeach;
            else:
            ?>
              <tr><td colspan="7" class="text-center">No Records Found</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>

</div>

<?php include('assets/includes/script.php'); ?>

<script>
  $(document).ready(function () {
    $('.deletebtn').click(function () {
      var id = $(this).val();
      $('.delete_user_id').val(id);
      $('#DeleteModal').modal('show');
    });
  });
</script>


<?php include('assets/includes/footer.php'); ?>
