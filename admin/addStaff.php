<?php
include('authentication.php');
include('assets/includes/header.php');

$query = "SELECT * FROM `users`";
$query_run = mysqli_query($con,$query);
$userRoles = mysqli_fetch_array($query_run);
                   
 if($userRoles['role'] == "admin")
         {

                                    
          
            include('assets/includes/sideForAdmin.php');
      
        


         }
           else if($userRoles['role'] == "user")
           {
                
            include('assets/includes/sidebar.php');

           }







include('config/dbcon.php');
include('assets/includes/topbar.php');

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

           
   
    <section class="content mt-4">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>
                                Staff - ADD
                                <a href="staff.php" class="btn btn-danger float-right">BACK</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            <form action="code.php" method="POST" enctype="multipart/form-data">

                            <input type="hidden" name="product_id" value="<?= $prodItem['id'] ?>">
                            
                            <div class="row">
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Staff Name</label>
                                        <input type="text" name="name" class="form-control" required placeholder="Enter Staff Name">
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Upload Photo</label>
                                        <input type="file" name="photo" class="form-control">
                                        <input type="hidden" name="old_image">
                                    </div>
                                   
                                </div>


                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Department</label>
                                        <input type="text" name="department" class="form-control" required placeholder="Enter Department">    
                                    </div>
                                </div>

                                

                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Position</label>
                                        <input type="text" name="position" class="form-control" required placeholder="Enter Position">    
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" name="title" class="form-control" required placeholder="Enter Title">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Education</label>
                                        <input type="text" name="education" class="form-control" required placeholder="Enter Education">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Date</label>
                                        <input type="number" name="date" class="form-control" required placeholder="Enter Date">
                                    </div>
                                </div>
                                
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Skills</label> <br>
                                        <textarea type="text" name="skills" class="form-control" required rows="3" placeholder="Enter Few Skills"></textarea>
                                       </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Upload Document</label>
                                        <input type="file" name="documents" class="form-control">
                                        <input type="hidden" name="old_image">
                                    </div>
                                    
                                </div>

                                

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <a type="submit" href="" name="addStaff" class="btn btn-success float-right"> <i class="fa fa-plus"></i>ADD</a>
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
    
  
 </div>
 <?php include('assets/includes/footer.php'); ?>
<?php include('assets/includes/script.php'); ?>