<?php
include('authentication.php');
include('assets/includes/header.php');
include('assets/includes/sideForAdmin.php');
include('config/dbcon.php');
include('assets/includes/topbar.php');
?>

<div class="content-wrapper">
<?php
if (isset($_GET['id'])) {
    $record_id = intval($_GET['id']);
    $query = "SELECT dr.*, s.name, s.department 
              FROM discipline_records dr 
              JOIN staff s ON s.id = dr.staff_id 
              WHERE dr.id = $record_id LIMIT 1";
    $query_run = mysqli_query($con, $query);

    if (mysqli_num_rows($query_run) > 0) {
        $record = mysqli_fetch_array($query_run);
?>
<section class="content mt-4">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php include('message.php'); ?>
                <div class="card">
                    <div class="card-header">
                        <h4>
                            Edit Discipline Record
                            <a href="discipline_records.php" class="btn btn-danger float-right">BACK</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="code.php" method="POST">
                            <input type="hidden" name="record_id" value="<?= $record['id'] ?>">

                            <div class="row">
                                <!-- Staff Info (readonly) -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Staff Name</label>
                                        <input type="text" class="form-control" value="<?= htmlspecialchars($record['name']) ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Department</label>
                                        <input type="text" class="form-control" value="<?= htmlspecialchars($record['department']) ?>" readonly>
                                    </div>
                                </div>

                                <!-- Editable Fields -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Offense Type</label>
                                        <input type="text" name="offense_type" value="<?= htmlspecialchars($record['offense_type']) ?>" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Date Reported</label>
                                        <input type="date" name="date_reported" value="<?= $record['date_reported'] ?>" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea name="description" class="form-control" rows="4" required><?= htmlspecialchars($record['description']) ?></textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Action Taken</label>
                                        <select name="action_taken" class="form-control" required>
                                            <?php
                                            $actions = ["Oral Warning 1", "Oral Warning 2", "Warning 1", "Warning 2", "Dismissal"];
                                            foreach ($actions as $action) {
                                                $selected = ($record['action_taken'] == $action) ? "selected" : "";
                                                echo "<option value='$action' $selected>$action</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" class="form-control" required>
                                            <option value="Pending" <?= $record['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                            <option value="Resolved" <?= $record['status'] == 'Resolved' ? 'selected' : '' ?>>Resolved</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="submit" name="update_discipline" class="btn btn-success btn-block">Update Record</button>
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
        echo "<div class='container mt-4'><div class='alert alert-danger'>No such record found.</div></div>";
    }
}
?>
</div>

<?php include('assets/includes/footer.php'); ?>
<?php include('assets/includes/script.php'); ?>
