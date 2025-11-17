<?php
include('authentication.php');
include('assets/includes/header.php');
include('assets/includes/sideForAdmin.php');
include('assets/includes/topbar.php');
include('config/dbcon.php');
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

<!-- Leave Add Modal -->
<div class="modal fade" id="AddLeaveModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Leave</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="code.php" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="nameSelect">Staff Name</label>
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
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label>Leave Type</label>
                <input type="text" name="leavetype" class="form-control" required placeholder="Enter Leave Type">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label>Start Date</label>
                <input type="date" name="startdate" class="form-control" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label>End Date</label>
                <input type="date" name="enddate" class="form-control" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control" required>
                  <option value="">Select</option>
                  <option value="Pending">Pending</option>
                  <option value="Approved">Approved</option>
                  <option value="Cancelled">Cancelled</option>
                </select>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label>Reason</label>
                <textarea name="reason" class="form-control" required rows="3" placeholder="Enter Reason"></textarea>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group text-right">
                <button type="submit" name="addLeave" class="btn btn-success">Save</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Content Header -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Leave Management</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Leave</li>
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
        <?php if (isset($_SESSION['status'])): ?>
          <div class="alert alert-success"> <?= $_SESSION['status']; unset($_SESSION['status']); ?> </div>
        <?php endif; ?>

        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Leave List</h3>
            <button class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#AddLeaveModal">Add Leave</button>
          </div>
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Staff Name</th>
                  <th>Leave Type</th>
                  <th>Start Date</th>
                  <th>End Date</th>
                  <th>Status</th>
                  <th>Reason</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $query = "SELECT l.*, s.name AS staff_name FROM `leave` l JOIN staff s ON s.id = l.staff_id";
                $query_run = mysqli_query($con, $query);
                if (mysqli_num_rows($query_run) > 0):
                  foreach ($query_run as $leave):
                ?>
                  <tr>
                    <td><?= $leave['staff_name']; ?></td>
                    <td><?= $leave['leave_type']; ?></td>
                    <td><?= $leave['start_date']; ?></td>
                    <td><?= $leave['end_date']; ?></td>
                    <td><?= $leave['status']; ?></td>
                    <td><?= $leave['reason']; ?></td>
                    <td>
                      <a href="leave-edit.php?leave_id=<?= $leave['leave_id']; ?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                      <a href="leaveProfile.php?leave_id=<?= $leave['leave_id']; ?>" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
                      <button type="button" value="<?= $leave['leave_id']; ?>" class="btn btn-danger btn-sm deletebtn"><i class="fa fa-trash"></i></button>
                    </td>
                  </tr>
                <?php
                  endforeach;
                else:
                ?>
                  <tr><td colspan="7" class="text-center">No Leave Records Found</td></tr>
                <?php endif; ?>
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

<script>
$(document).ready(function() {
  $('.deletebtn').click(function(e) {
    e.preventDefault();
    var id = $(this).val();
    $('.delete_user_id').val(id);
    $('#DeleteModal').modal('show');
  });
});
</script>