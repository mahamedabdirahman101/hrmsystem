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
if (isset($_GET['leave_id'])) {
    $leave_id = $_GET['leave_id'];
    $query = "SELECT l.*, s.name, s.department 
              FROM `leave` l 
              JOIN staff s ON s.id = l.staff_id 
              WHERE l.leave_id = '$leave_id' LIMIT 1";
    $query_run = mysqli_query($con, $query);

    if (mysqli_num_rows($query_run) > 0) {
        $leaveItem = mysqli_fetch_array($query_run);
?>

<section class="content mt-4">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php include('message.php'); ?>
                <div class="card">
                    <div class="card-header">
                        <h4>
                            Edit Leave Request
                            <a href="leave.php" class="btn btn-danger float-right">BACK</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="code.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="leave_id" value="<?= $leaveItem['leave_id'] ?>">

                            <div class="row">
                                <!-- Name & Department (Read-only) -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Staff Name</label>
                                        <input type="text" class="form-control" value="<?= $leaveItem['name']; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Department</label>
                                        <input type="text" class="form-control" value="<?= $leaveItem['department']; ?>" readonly>
                                    </div>
                                </div>

                                <!-- Editable Fields -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Leave Type</label>
                                        <input type="text" name="leavetype" value="<?= $leaveItem['leave_type']; ?>" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Start Date</label>
                                        <input type="date" name="startdate" value="<?= $leaveItem['start_date']; ?>" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <input type="date" name="enddate" value="<?= $leaveItem['end_date']; ?>" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" class="form-control" required>
                                            <option value="Pending" <?= ($leaveItem['status'] == 'Pending') ? 'selected' : '' ?>>Pending</option>
                                            <option value="Approved" <?= ($leaveItem['status'] == 'Approved') ? 'selected' : '' ?>>Approved</option>
                                            <option value="Cancelled" <?= ($leaveItem['status'] == 'Cancelled') ? 'selected' : '' ?>>Cancelled</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Document Upload -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Upload Document (PDF only)</label>
                                        <input type="file" name="document" class="form-control">
                                        <input type="hidden" name="old_document" value="<?= $leaveItem['documents']; ?>">
                                        <br>
                                        <?php if (!empty($leaveItem['documents'])): ?>
                                            <a href="uploads/leaveDocuments/<?= $leaveItem['documents']; ?>" target="_blank" class="text-primary">
                                                View Existing Document
                                            </a>
                                        <?php else: ?>
                                            <p class="text-muted">No document uploaded.</p>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="submit" name="updateLeave" class="btn btn-success btn-block">Save & Approve</button>
                                    </div>
                                </div>
                            </div> <!-- /.row -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
    } else {
        echo "<div class='container mt-4'><div class='alert alert-danger'>No such leave request found.</div></div>";
    }
}
?>

</div> <!-- /.content-wrapper -->

<?php include('assets/includes/footer.php'); ?>
<?php include('assets/includes/script.php'); ?>
