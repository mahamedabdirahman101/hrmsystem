<?php
include('authentication.php');
include('assets/includes/header.php');
include('assets/includes/sideForAdmin.php');
include('assets/includes/topbar.php');
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Department Profile</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Department Profile</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <?php
                        if (isset($_GET['dept_id'])) {
                            $dept_id = $_GET['dept_id'];
                            $query = "SELECT * FROM `departments` WHERE `id`='$dept_id' LIMIT 1";
                            $query_run = mysqli_query($con, $query);

                            if (mysqli_num_rows($query_run) > 0) {
                                foreach ($query_run as $dept_info) {
                        ?>
                                    <div class="card-body box-profile">
                                        <div class="text-center">
                                            <img class="profile-user-img img-fluid img-circle" src="../../dist/img/user4-128x128.jpg" alt="User profile picture">
                                        </div>

                                        <h3 class="profile-username text-center">Department</h3>

                                        <ul class="list-group list-group-unbordered mb-3">
                                            <li class="list-group-item">
                                                <b>Department</b> <a class="float-right"><?= $dept_info['name']; ?></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Category</b> <a class="float-right"><?= $dept_info['category']; ?></a>
                                            </li>
                                        </ul>

                                        <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
                                    </div>
                    </div>

                    <!-- About Me Box -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">About Department</h3>
                        </div>
                        <div class="card-body">
                            
                         

                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Overview</strong>
                            <p class="text-muted"><?= $dept_info['overview']; ?></p>
                            <hr>

                            <strong><i class="fas fa-pencil-alt mr-1"></i> No. of Staffs</strong>
                            <p class="text-muted">
                                <?php
                                $departmentName = $dept_info['name'];
                                $countQuery = "SELECT COUNT(*) AS staff_count FROM staff WHERE department = ?";
                                $stmt = $con->prepare($countQuery);
                                $stmt->bind_param("s", $departmentName);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                if ($result && $row = $result->fetch_assoc()) {
                                    echo $row['staff_count'];
                                } else {
                                    echo "0";
                                }
                                ?>
                            </p>

                            <hr>
                            <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>
                            <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
                        </div>
                    </div>
                </div>

                <!-- Staff Table -->
                <div class="col-md-9">
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stmt = $con->prepare("SELECT * FROM `staff` WHERE `department` = ?");
                                $stmt->bind_param("s", $departmentName);
                                $stmt->execute();
                                $query_run = $stmt->get_result();

                                if (mysqli_num_rows($query_run) > 0) {
                                    foreach ($query_run as $staff_info) {
                                ?>
                                        <tr>
                                            <td><?= $staff_info['id']; ?></td>
                                            <td><?= $staff_info['name']; ?></td>
                                            <td><?= $staff_info['position']; ?></td>
                                            <td><?= $staff_info['date']; ?></td>

                                            <?php
                                            $user = $_SESSION['auth_user'];
                                            $role = $user['user_role'];
                                            ?>
                                            <td>
                                                <?php if ($role === 'admin' || $role === 'user') : ?>
                                                    <a href="staffs-edit.php?staff_id=<?= $staff_info['id']; ?>" class="btn btn-sm btn-info"><i class="fa fa-edit"></i> Edit</a>
                                                <?php endif; ?>
                                                <a href="staffProfile.php?staff_id=<?= $staff_info['id']; ?>" class="btn btn-sm btn-success"><i class="fa fa-eye"></i> View Profile</a>
                                                <?php if ($role !== 'user') : ?>
                                                    <button type="button" value="<?= $staff_info['id']; ?>" class="btn btn-sm btn-danger deletebtn">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='5' class='text-center'>No Record Found</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php
                                }
                            }
                        }
include('assets/includes/footer.php');
include('assets/includes/script.php');
?>
