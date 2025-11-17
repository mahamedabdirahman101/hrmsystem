<?php
include('authentication.php');
include('assets/includes/header.php');
include('assets/includes/sideForAdmin.php');
include('assets/includes/topbar.php');
include('config/dbcon.php');
?>
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Edit - Staffs</li>
                    </ol>
                </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
            </div>
           <!-- /.content-header -->

    
    <section class="content">
      <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                                 <div class="card-header">
                                        <h3 class="card-title">Edit - Staffs</h3>
                                        <a href="staff.php" class="btn  btn-danger btn-sm float-right">BACK</a>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <form action="code.php" method="POST">
                                                        <div class="modal-body">
                                                            <?php
                                                                if(isset($_GET['staff_id']))
                                                                {
                                                                    $staffs_id =  $_GET['staff_id'];
                                                                    $query = "SELECT * FROM `staffs` WHERE `id`='$staffs_id' LIMIT 1";
                                                                    $query_run = mysqli_query($con, $query);

                                                                    if(mysqli_num_rows($query_run) > 0)
                                                                    {
                                                                        foreach($query_run as $staff_info)
                                                                        {
                                                                            ?>
                                                                            <input type="hidden" name="id" value="<?= $staff_info['id']; ?>">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label for="">Name</label>
                                                                                    <input type="text" name="name" class="form-control" value="<?= $staff_info['name']; ?>" placeholder="Name">
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label for="">Department</label>
                                                                                    <input type="text" name="department" value="<?= $staff_info['department']; ?>" class="form-control" placeholder="Department">
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-6"> 
                                                                                <div class="form-group">
                                                                                    <label for="">Position</label>
                                                                                    <input type="text" name="position" value="<?= $staff_info['position']; ?>" class="form-control" placeholder="Position">
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label for="">Joined_Date</label>
                                                                                    <input type="number" name="date" value="<?= $staff_info['date']; ?>" class="form-control" placeholder="Joined Date">
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label for="">Education</label>
                                                                                    <input type="text" name="education" class="form-control" value="<?= $staff_info['education']; ?>" placeholder="Name">
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label for="">Title</label>
                                                                                    <input type="text" name="title" value="<?= $staff_info['title']; ?>" class="form-control">
                                                                                </div>
                                                                            </div>
                                                                            
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label for="">Address</label>
                                                                                    <input type="text" name="address" value="<?= $staff_info['address']; ?>" class="form-control">
                                                                                </div>
                                                                             </div>
                                                                        
                                                                             <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label for="">Skills</label>
                                                                                    <textarea type="text" name="skills" class="form-control" required rows="3" placeholder="Enter Skills"><?= $staff_info['skills']; ?></textarea>
                                                                                </div>
                                                                            </div>

                                                                     <div class="col-md-8">
                                                                        <div class="form-group">
                                                                            <label>Upload Image</label>
                                                                            <input type="file" name="photo" class="form-control">
                                                                            <input type="hidden" name="old_photo" value="<?= $staff_info['photo']; ?>">
                                                                        </div>
                                                                        <img src="uploads/staff/<?= $staff_info['photo']; ?>" width="50px" height="50px" alt="image">
                                                                    </div>
                                                                                                                        
                                                                            <?php
                                                                        }
                                                                    } 
                                                                    else {
                                                                        echo '<h4>No Record Found!</h4>';
                                                                    }
                                                                }

                                                            ?>
                                                                
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" name="updateStaff" class="btn btn-success">Update</button>
                                                        </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                       <!-- /.card-body -->
                    </div>
                  <!-- /.card -->
                </div>
            </div>
    </div>
 </section>




</div>   

<?php include('assets/includes/footer.php'); ?>
<?php include('assets/includes/script.php'); ?>