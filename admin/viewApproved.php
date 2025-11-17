<?php
include('authentication.php');
include('assets/includes/header.php');
include('assets/includes/sideForAdmin.php');
include('assets/includes/topbar.php');
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Approved Profile</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Approved Profile</li>
                    </ol>
                </div>
            </div>
        </div></section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">

                    <div class="card card-primary card-outline">

                        <?php
                        if (isset($_GET['approved_id'])) {
                            $approved_id = $_GET['approved_id'];
                            $query = "SELECT * FROM `approve_leave` WHERE `leave_id`='$approved_id' LIMIT 1";
                            $query_run = mysqli_query($con, $query);

                            if (mysqli_num_rows($query_run) > 0) {
                                foreach ($query_run as $approve_info) {
                                    ?>
                                    <div class="card-body box-profile">
                                        <div class="text-center">
                                            </div>

                                        <h3 class="profile-username text-center">
                                            <p class="text-muted text-center"><?= $approve_info['department']; ?></p>
                                            <?= $approve_info['name']; ?>
                                        </h3>

                                        <ul class="list-group list-group-unbordered mb-3">
                                            <li class="list-group-item">
                                                <b>Department</b> <a class="float-right"><?= $approve_info['department']; ?></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Leave Type</b> <a class="float-right"><?= $approve_info['leave_type']; ?></a>
                                            </li>
                                        </ul>

                                        <ul class="nav nav-pills">
                                            </ul>

                                        </div>
                                    <?php
                                }
                            }
                        }
                        ?>

                        </div>
                    <!-- <div class="card card-primary">

                        <?php
                        // Get user information from session
                        $user = $_SESSION['auth_user'];

                        // Check if the user is an admin
                        $isAdmin = ($user['user_role'] === 'admin');
                        $isUser = ($user['user_role'] === 'user');
                        $isViewer = ($user['user_role'] === 'viewer');
                        ?>

                        <?php if ($isUser): ?>
                            <a href="leave-edit.php?staff_id=<?= $staff_info['leave_id']; ?>" type="button"
                                class="btn btn-sm btn-info" data-dismiss="modal"><i class="fa fa-edit"></i>Edit</a>
                        <?php endif; ?>

                        <?php if ($isAdmin): ?>
                            <a href="leave-edit.php?staff_id=<?= $staff_info['approved_id']; ?>" type="button"
                                class="btn btn-sm btn-info" data-dismiss="modal"><i class="fa fa-edit"></i>Edit</a>
                        <?php endif; ?>

                        </div> -->
                    </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <a href="leave.php" class="btn  btn-danger btn-sm float-right">Back</a>
                            <br>

                            <div class="card-body">
                                <strong><i class="fas fa-book mr-1"></i> Days Left</strong>

                                <p class="text-muted">
                                    <?php
                                    if (isset($approve_info['start_date']) && isset($approve_info['end_date'])) {
                                        $startDate = $approve_info['start_date'];
                                        $endDate = $approve_info['end_date'];
                                        $daysDifference = mysqli_fetch_array(mysqli_query($con, "SELECT DATEDIFF('$endDate', CURDATE())"))[0];
                                        echo $daysDifference . " days";
                                    } else {
                                        echo "Start and End dates are not set.";
                                    }
                                    ?>
                                </p>

                                <hr>

                                <strong><i class="fas fa-map-marker-alt mr-1"></i> Leave Type</strong>

                                <p class="text-muted"><?= $approve_info['leave_type']; ?></p>

                                <hr>

                                <strong><i class="fas fa-pencil-alt mr-1"></i> Start Date</strong>

                                <p class="text-muted">
                                    <?= $approve_info['start_date']; ?>
                                </p>

                                <hr>

                                <strong><i class="far fa-file-alt mr-1"></i>End Date</strong>

                                <p class="text-muted"><?= $approve_info['end_date']; ?></p>

                                <hr>

                                <strong><i class="far fa-file-alt mr-1"></i>Status</strong>

                                <p class="text-muted text-green"><?= $approve_info['status']; ?></p>

                                <?php if ($isUser): ?>
                                    <div class="form-group">

                                    </div>
                                <?php endif; ?>

                                <?php if ($isAdmin): ?>

                                    <div class="form-group">
                                        <div class="float-right">
                                            </div>

                                        <ul class="nav nav-pills">
                                            <li class="nav-item"><a
                                                    href="uploads/leaveDocuments/<?= $approve_info['documents']; ?>"
                                                    class="nav-link text-blue"> <i class="fa fa-file-pdf-o"></i> View
                                                    Document</a></li>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                            </div>
                            </div></div>
                    </div>
                </div>
            </div></section>
    </div>
<script>
    const viewButton = document.getElementById('viewButton');

    viewButton.addEventListener('click', function(event) {
        event.preventDefault();

        window.open('', '_blank');
    });
</script>

<?php include('assets/includes/footer.php'); ?>
<?php include('assets/includes/script.php'); ?>