<?php
include('authentication.php');
include('assets/includes/header.php');
include('config/dbcon.php');
include('assets/includes/sideForAdmin.php');
include('assets/includes/topbar.php');








?>
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">

<!-- User Modal -->
<div class="modal fade" id="AddStaffModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Staff</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        

        <form action="code.php" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
<input type="hidden" name="product_id" value="<?= $prodItem['id'] ?>">

<div class="row">
    
    <div class="col-md-12">
        <div class="form-group">
            <label>Staff Name</label>
            <input type="text" name="name" class="form-control" required placeholder="Enter Staff Name">
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label>Upload Photo</label>
            <input type="file" name="photo" class="form-control">
            <input type="hidden" name="old_image">
        </div>
       
    </div>


    <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Department</label>
                                          <?php
                                            $query = "SELECT * FROM `departments`";
                                            $query_run = mysqli_query($con, $query);
                                            ?>
                                            <select name="deptName" class="form-control" required id="nameSelect">
                                                <option value="">Select Department</option>
                                                <?php foreach ($query_run as $dept): ?>
                                                  <option value="<?= $dept['name']; ?>"><?= $dept['name']; ?></option>
                                                     
                                                <?php endforeach; ?>
                                            </select>
                                     </div>
                          </div>

    

    <div class="col-md-12">
        <div class="form-group">
            <label>Position</label>
            <input type="text" name="position" class="form-control" required placeholder="Enter Position">    
        </div>
    </div>

    <div class="col-md-12">
    <div class="form-group">
      <label for="gender">Gender</label>
      <select name="gender" class="form-control" required>
        <option value="">Select Gender</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        <option value="Other">Other</option>
      </select>
    </div>
  </div>

    <div class="col-md-12">
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" class="form-control" required placeholder="Enter Title">
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label>Education</label>
            <input type="text" name="education" class="form-control" required placeholder="Enter Education">
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label>Joined_Date</label>
            <input type="number" name="date" class="form-control" required placeholder="Enter Date">
        </div>
    </div>
   
    <div class="col-md-12">
        <div class="form-group">
            <label>Address</label>
            <input type="text" name="address" class="form-control" required placeholder="Enter Address">
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label>Phone</label>
            <input type="number" name="phone" class="form-control" required placeholder="Enter Phone Number">
        </div>
    </div>
    
    <div class="col-md-12">
        <div class="form-group">
            <label>Skills</label> <br>
            <textarea type="text" name="skills" class="form-control" required rows="3" placeholder="Enter Few Skills"></textarea>
           </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
    <label>Upload Document (PDF only)</label>
    <input type="file" name="documents[]" class="form-control" multiple required>
  </div>
        
    </div>


 
  

 


    

    <div class="col-md-4">
        <div class="form-group">
            <!-- <a type="submit" href="" name="addStaffs" class="btn btn-success float-right"> <i class="fa fa-plus"></i>ADD</a> -->
            <div class="modal-footer">
       
        <button type="submit" name="addStaffs" class="btn btn-success btn-block">Save</button>
      </div>
        </div>
    </div>
</div>
</div>
</form>

    
      
      
    </div>
  </div>
</div>









<!-- delete user -->

<!-- Modal -->
<div class="modal fade" id="DeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Staff</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="code.php" method="POST">
          <div class="modal-body">
            <input type="hidden" name="delete_id" class="delete_user_id">

            <p>
              Are you sure. You want to delete this Staff ?
            </p>
          </div>
          <div class="modal-footer">
            <a type="button" class="btn btn-secondary" data-dismiss="modal">Close</a>
           <button type="submit" name="DeleteStaffbtn" class="btn btn-danger">Yes, Delete It!</button>

          </div>
      </form>
      
    </div>
  </div>
</div>






         <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Staffs</li>
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

            <?php

                if(isset($_SESSION['status']))
                {
                    echo "<h4 class='alert alert-success alert-dismissible fade show'>".$_SESSION['status']."</h4>";
                    unset($_SESSION['status']);
                }

                if(isset($_SESSION['alert']))
                {
                    echo "<h4 class='alert alert-warning alert-dismissible fade show'>".$_SESSION['alert']."</h4>";
                    unset($_SESSION['alert']);
                }

            ?>
            <!-- <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Staff Management</h3>
                    
                  

                  

                    

                      

                    
                </div> -->



                <?php



// Get user information from session
$user = $_SESSION['auth_user'];

// Check if the user is an admin
$isAdmin = ($user['user_role'] === 'admin'); 
$isUser = ($user['user_role'] === 'user'); 
$isViewer = ($user['user_role'] === 'viewer');

?>

    <?php if ($isUser): ?> 
      <!-- <div class="card"> -->
    <div class="card-header">
    <h3 class="card-title">Staff Management</h3>

        <a href="" class="btn  btn-primary btn-sm float-right" data-toggle="modal" data-target="#AddStaffModal">Add Staff</a>
    </div>
    <?php endif; ?>  

    <?php if ($isAdmin): ?> 
      <div class="card">
    <div class="card-header">
    <h3 class="card-title">Staff Management</h3>

        <a href="" class="btn  btn-primary btn-sm float-right" data-toggle="modal" data-target="#AddStaffModal">Add Staff</a>
    </div>
    <?php endif; ?> 

                
              <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                              <th>Id</th>
                              <th>Name</th>
                              <th>Department</th>
                              <th>Position</th>
                              <th>Date</th>
                              <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>


                            


                            <?php
                              $query = "SELECT * FROM `staff`";
                              $query_run = mysqli_query($con,$query);

                              if(mysqli_num_rows($query_run) > 0)
                              {
                                  foreach($query_run as $staff_info)
                              {
                                  ?>

                                  <tr>
                                      <td><?= $staff_info['id']; ?></td>
                                      <td><?= $staff_info['name']; ?></td>
                                      <td><?= $staff_info['department']; ?></td>
                                      <td><?= $staff_info['position']; ?></td>
                                      <td><?= $staff_info['date']; ?></td>



                                      
                <?php



// Get user information from session
$user = $_SESSION['auth_user'];

// Check if the user is an admin
$isAdmin = ($user['user_role'] === 'admin'); 
$isUser = ($user['user_role'] === 'user'); 
$isViewer = ($user['user_role'] === 'viewer');

?>

    <?php if ($isUser): ?> 
      <td>
                                         <a href="staffs-edit.php?staff_id=<?= $staff_info['id']; ?>"type="button" class="btn btn-sm btn-info" data-dismiss="modal"><i class="fa fa-edit"></i>Edit</a>
                                         <a href="staffProfile.php?staff_id=<?= $staff_info['id']; ?>" type="button" value="" class="btn btn-sm btn-success">
                                          <i class="fa fa-eye"></i>View Profile
                                            </a>
                                         <button type="button" value="<?= $staff_info['id']; ?>" class="btn btn-sm btn-danger deletebtn">
                                          <i class="fa fa-trash"></i>
                                         </button>
                                         <!-- <a target="_blank" href="print-details.php?staff_id=<?=$staff_info['id']?>" class="btn btn-sm btn-primary"> <i class="fa fa-file-pdf-o"></i> Print  Details</a> -->
                              

                                      </td>
    <?php endif; ?>  

    <?php if ($isAdmin): ?> 
      <td>
                                         <a href="staffs-edit.php?staff_id=<?= $staff_info['id']; ?>"type="button" class="btn btn-sm btn-info" data-dismiss="modal"><i class="fa fa-edit"></i>Edit</a>
                                         <a href="staffProfile.php?staff_id=<?= $staff_info['id']; ?>" type="button" value="" class="btn btn-sm btn-success">
                                          <i class="fa fa-eye"></i>View Profile
                                            </a>
                                         <!-- <button type="button" value="<?= $staff_info['id']; ?>" class="btn btn-sm btn-danger deletebtn">
  <i class="fa fa-trash"></i>
</button> -->

<button type="button" value="<?= $staff_info['id']; ?>" class="btn btn-danger deletebtn">
                                          <i class="fa fa-trash"></i>
                              </button>
                              


                                         <!-- <a target="_blank" href="print-details.php?staff_id=<?=$staff_info['id']?>" class="btn btn-sm btn-primary"> <i class="fa fa-file-pdf-o"></i> Print  Details</a> -->
                              

                                      </td>
    <?php endif; ?> 
    <?php if ($isViewer): ?>                          
                                    <td>
                                         
                                         <a href="staffProfile.php?staff_id=<?= $staff_info['id']; ?>" type="button" value="" class="btn btn-sm btn-success">
                                          <i class="fa fa-eye"></i>View Profile
                                            </a>
                                         <button type="button" value="<?= $staff_info['id']; ?>" class="btn btn-sm btn-danger deletebtn">
                                          <i class="fa fa-trash"></i>
                                         </button>
                                         <!-- <a target="_blank" href="print-details.php?staff_id=<?=$staff_info['id']?>" class="btn btn-sm btn-primary"> <i class="fa fa-file-pdf-o"></i> Print  Details</a> -->
                              

                                      </td>
                                      <?php endif; ?> 
                                  </tr>

                                  <?php

                              }
                              }
                              else 
                              {
                                  ?>
                                  <tr>
                                      <td colspan='6' class='text-center'>No Record Found</td>
                                  </tr>

                                  <?php
                              }

                          ?>
                            

                            </tbody>
                            <!-- <tfoot>
                            <tr>
                              <th>Rendering engine</th>
                              <th>Browser</th>
                              <th>Platform(s)</th>
                              <th>Engine version</th>
                              <th>CSS grade</th>
                            </tr>
                            </tfoot> -->
               </table>
                         </div>
                       <!-- /.card-body -->
                    </div>
                  <!-- /.card -->
            </div>
        </div>
    </div>
 </section>

      
</div>   

<?php include('assets/includes/script.php'); ?>
                            <script>
                              $(document).ready(function (){
                                $('.email_id').keyup(function (e){
                                  var email = $('.email_id').val();
                                  //console.log(email);

                                  $.ajax({
                                    type: "POST",
                                    url: "code.php",
                                    data: {
                                      'check_Emailbtn' :1,
                                      'email' : email,
                                    },
                                    success: function(response){
                                     // console.log(response);

                                     $('.email_error').text(response);
                                    }
                                  });
                                });
                              });
                            </script>
                        <script>
                               $(document).ready(function (){
                                $('.deletebtn').click(function (e) {
                                  e.preventDefault();

                                  var staffid = $(this).val();
                                  $('.delete_user_id').val(staffid);
                                  $('#DeleteModal').modal('show');
                                });
                               });
                              </script>

                             


<?php include('assets/includes/footer.php'); ?>
                
                             

