<?php
include('authentication.php');
include('assets/includes/header.php');
include('assets/includes/sideForAdmin.php');
include('config/dbcon.php');
include('assets/includes/topbar.php');
?>

<div class="content-wrapper">
    <section class="content mt-4">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php include('message.php'); ?>
                    <div class="card">
                        <div class="card-header">
                            <h4>Resolved Discipline Records</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Staff Name</th>
                                        <th>Department</th>
                                        <th>Offense Type</th>
                                        <th>Action Taken</th>
                                        <th>Date Reported</th>
                                        <th>Status</th>
                                        <th>Resolved At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT r.*, s.name, s.department 
                                              FROM resolved_discipline r
                                              JOIN staff s ON s.id = r.staff_id 
                                              ORDER BY r.resolved_at DESC";
                                    $query_run = mysqli_query($con, $query);

                                    if (mysqli_num_rows($query_run) > 0) {
                                        while ($row = mysqli_fetch_assoc($query_run)) {
                                            ?>
                                            <tr>
                                                <td><?= $row['id']; ?></td>
                                                <td><?= htmlspecialchars($row['name']); ?></td>
                                                <td><?= htmlspecialchars($row['department']); ?></td>
                                                <td><?= htmlspecialchars($row['offense_type']); ?></td>
                                                <td><?= htmlspecialchars($row['action_taken']); ?></td>
                                                <td><?= $row['date_reported']; ?></td>
                                                <td><span class="badge badge-success"><?= $row['status']; ?></span></td>
                                                <td><?= $row['resolved_at']; ?></td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        echo "<tr><td colspan='8' class='text-center'>No resolved records found.</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div> <!-- /.card-body -->
                    </div> <!-- /.card -->
                </div> <!-- /.col -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>
</div> <!-- /.content-wrapper -->

<?php include('assets/includes/footer.php'); ?>
<?php include('assets/includes/script.php'); ?>
