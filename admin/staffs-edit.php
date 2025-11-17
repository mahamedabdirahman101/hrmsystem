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
if (isset($_GET['staff_id'])) {
    $staffs_id = $_GET['staff_id'];
    $query = "SELECT * FROM staff WHERE id='$staffs_id'";
    $query_run = mysqli_query($con, $query);

    if (mysqli_num_rows($query_run) > 0) {
        $staffItem = mysqli_fetch_array($query_run);
?>

<section class="content mt-4">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php include('message.php'); ?>
                <div class="card">
                    <div class="card-header">
                        <h4>
                            Staff - EDIT
                            <a href="staff.php" class="btn btn-danger float-right">BACK</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="code.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="staffs_id" value="<?= $staffItem['id'] ?>">

                            <div class="row">

                                <!-- Name -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Name</label>
                                        <input type="text" name="name" class="form-control" value="<?= $staffItem['name']; ?>" required>
                                    </div>
                                </div>

                                <!-- Department -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Department</label>
                                        <?php
                                        $dept_query = "SELECT * FROM `departments`";
                                        $dept_result = mysqli_query($con, $dept_query);
                                        ?>
                                        <select name="department" class="form-control" required>
                                            <option value="">Select Department</option>
                                            <?php foreach ($dept_result as $dept): ?>
                                                <option value="<?= $dept['name']; ?>" <?= ($staffItem['department'] == $dept['name']) ? 'selected' : '' ?>>
                                                    <?= $dept['name']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- Position -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Position</label>
                                        <input type="text" name="position" class="form-control" value="<?= $staffItem['position']; ?>" required>
                                    </div>
                                </div>

                                <!-- Gender -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Gender</label>
                                    <select name="gender" class="form-control" required>
                                        <option value="">Select Gender</option>
                                        <option value="Male" <?= ($staffItem['gender'] === 'Male') ? 'selected' : '' ?>>Male</option>
                                        <option value="Female" <?= ($staffItem['gender'] === 'Female') ? 'selected' : '' ?>>Female</option>
                                        <option value="Other" <?= ($staffItem['gender'] === 'Other') ? 'selected' : '' ?>>Other</option>
                                    </select>
                                </div>
                            </div>


                                <!-- Date -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Joined Date (Year)</label>
                                        <input type="number" name="date" class="form-control" value="<?= $staffItem['date']; ?>" required>
                                    </div>
                                </div>

                                <!-- Education -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Education</label>
                                        <input type="text" name="education" class="form-control" value="<?= $staffItem['education']; ?>" required>
                                    </div>
                                </div>

                                <!-- Title -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Title</label>
                                        <input type="text" name="title" class="form-control" value="<?= $staffItem['title']; ?>" required>
                                    </div>
                                </div>

                                <!-- Address -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Address</label>
                                        <input type="text" name="address" class="form-control" value="<?= $staffItem['address']; ?>" required>
                                    </div>
                                </div>

                                <!-- Skills -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Skills</label>
                                        <textarea name="skills" class="form-control" rows="3" required><?= $staffItem['skills']; ?></textarea>
                                    </div>
                                </div>

                                <!-- Photo Upload -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Upload Image</label>
                                        <input type="file" name="photo" class="form-control">
                                        <input type="hidden" name="old_photo" value="<?= $staffItem['photo']; ?>">
                                        <br>
                                        <img src="uploads/staff/<?= $staffItem['photo']; ?>" width="50px" height="50px" alt="Staff Image">
                                    </div>
                                </div>

                                <!-- Document Upload -->
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Upload Documents (PDF only)</label>
                                        <input type="file" name="documents[]" class="form-control" multiple>
                                        <input type="hidden" name="old_documents" value="<?= $staffItem['documents']; ?>">
                                        <br>
                                        <strong>Existing Documents:</strong><br>
                                        <?php
                                        $docs = explode(',', $staffItem['documents']);
                                        if (!empty($docs[0])) {
                                            foreach ($docs as $doc) {
                                                echo "<a href='uploads/docs/$doc' target='_blank'>$doc</a><br>";
                                            }
                                        } else {
                                            echo "<span class='text-muted'>No documents uploaded.</span>";
                                        }
                                        ?>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="submit" name="updateStaffs" class="btn btn-primary btn-block">Update</button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
    } else {
        echo "<div class='container mt-4'><div class='alert alert-danger'>No such staff found.</div></div>";
    }
}
?>

</div>

<?php include('assets/includes/footer.php'); ?>
<?php include('assets/includes/script.php'); ?>
