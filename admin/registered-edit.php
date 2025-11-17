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
                    <li class="breadcrumb-item active">Edit - Registered User</li>
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
                                        <h3 class="card-title">Edit - Registered User</h3>
                                        <a href="registered.php" class="btn  btn-danger btn-sm float-right">BACK</a>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <form action="code.php" method="POST">
                                                        <div class="modal-body">
                                                            <?php
                                                                if(isset($_GET['id']))
                                                                {
                                                                    $user_id =  $_GET['id'];
                                                                    $query = "SELECT * FROM `users` WHERE `id`='$user_id' LIMIT 1";
                                                                    $query_run = mysqli_query($con, $query);

                                                                    if(mysqli_num_rows($query_run) > 0)
                                                                    {
                                                                        foreach($query_run as $row)
                                                                        {
                                                                            ?>
                                                                            <input type="hidden" name="id" value="<?php echo $row ['id'] ?>">
                                                                            <div class="form-group">
                                                                                <label for="">Name</label>
                                                                                <input type="text" name="name" class="form-control" value="<?php echo $row['name'] ?>" placeholder="Name">
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label for="">Phone Number</label>
                                                                                <input type="number" name="phone" value="<?php echo $row['phone'] ?>" class="form-control" placeholder="Phone Number">
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label for="">Email Id</label>
                                                                                <input type="email" name="email" value="<?php echo $row['email'] ?>" class="form-control" placeholder="Email">
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label for="">Password</label>
                                                                                <input type="password" name="password" value="<?php echo $row['password'] ?>" class="form-control" placeholder="Password">
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label for="">Give Role</label>
                                                                                <select name="role_as" class="form-control" required>
                                                                                    <option value="">Select</option>
                                                                                    <option value="0">User</option>
                                                                                    <option value="1">Admin</option>
                                                                                </select>
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
                                                            <button type="submit" name="updateUser" class="btn btn-success">Update</button>
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