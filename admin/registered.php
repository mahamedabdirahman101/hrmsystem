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
<div class="modal fade" id="AddUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="code.php" method="POST">
      <div class="modal-body">
            <div class="form-group">
                <label for="">Name</label>
                <input type="text" name="name" class="form-control" placeholder="Name">
            </div>

            <div class="form-group">
                <label for="">Phone Number</label>
                <input type="number" name="phone" class="form-control" placeholder="Phone Number">
            </div>

            <div class="form-group">
                <label for="">Email Id</label>
                <span class="email_error text-danger ml-2"></span>
                <input type="email" name="email" class="form-control email_id" placeholder="Email">
            </div>

            <div class="row">
              <div class="col-md-6">
                    <div class="form-group">
                      <label for="">Password</label>
                      <input type="password" name="password" class="form-control" placeholder="Password">
                    </div>
              </div>
              <div class="col-md-6">
                    <div class="form-group">
                      <label for="">Confirm Password</label>
                      <input type="password" name="confirmpassword" class="form-control" placeholder="Confirm Password">
                    </div>
              </div>
        
              <div class="col-md-6">
                  <div class="form-group">
                  <label for="">Confirm Password</label>
                      <input type="text" name="role_as" class="form-control" placeholder="User Role">
                   </div>
              </div>
              
            </div>

          
      </div>
      <div class="modal-footer">
        <a type="button" class="btn btn-danger" data-dismiss="modal">Close</a>
        <button type="submit" name="addUser" class="btn btn-primary">Save</button>
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
        <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="code.php" method="POST">
          <div class="modal-body">
            <input type="hidden" name="delete_id" class="delete_user_id">
            <p>
              Are you sure. You want to delete this data ?
            </p>
          </div>
          <div class="modal-footer">
            <a type="button" class="btn btn-secondary" data-dismiss="modal">Close</a>
            <button type="submit" name="DeleteUserbtn" class="btn btn-danger">Yes, Delete It!</button>
          </div>
      </form>
      
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="ApproveModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Approve Leave</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="code.php" method="POST">
          <div class="modal-body">
            <input type="hidden" name="approve_id" class="approve_staff_id">
            <p>
              Are you sure. You want to approve this leave ?
            </p>
          </div>
          <div class="modal-footer">
            <a type="button" class="btn btn-secondary" data-dismiss="modal">Close</a>
            <button type="submit" name="MoveUserbtn" class="btn btn-success">Yes, Approve It!</button>
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
              <li class="breadcrumb-item active">Registered Users</li>
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
            
                    <?php



            // Get user information from session
            $user = $_SESSION['auth_user'];

            // Check if the user is an admin
            $isAdmin = ($user['user_role'] === 'admin'); 
            $isUser = ($user['user_role'] === 'user'); 
            $isViewer = ($user['user_role'] === 'viewer');

            ?>
           
                <?php if ($isUser): ?> 
                  <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Registered User</h3>

                    <a href="#" class="btn  btn-primary btn-sm float-right" data-toggle="modal" data-target="#AddUserModal">Add User</a>
                </div>
                <?php endif; ?>  

                <?php if ($isAdmin): ?> 
                  <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Registered User</h3>

                    <a href="#" class="btn  btn-primary btn-sm float-right" data-toggle="modal" data-target="#AddUserModal">Add User</a>
                </div>
                <?php endif; ?> 



          
                
                
              <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                              <th>Id</th>
                              <th>Name</th>
                              <th>Phone</th>
                              <th>Email</th>
                              <th>Role</th>
                              <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php
                              $query = "SELECT * FROM `users`";
                              $query_run = mysqli_query($con,$query);

                              if(mysqli_num_rows($query_run) > 0)
                              {
                                  foreach($query_run as $row)
                              {
                                  ?>

                                  <tr>
                                      <td><?php echo $row['id']; ?></td>
                                      <td><?php echo $row['name']; ?></td>
                                      <td><?php echo $row['phone']; ?></td>
                                      <td><?php echo $row['email']; ?></td>
                                      <td><?php echo $row['role']; ?></td>
                                      
                                      <td>

                                         <a href="registered-edit.php?id=<?php echo $row['id']; ?>"type="button" class="btn btn-sm btn-info" data-dismiss="modal"><i class="fa fa-edit"></i></a>
                                        <button type="button" value="<?php echo $row['id']; ?>" class="btn btn-danger deletebtn">
                                          <i class="fa fa-trash"></i>
                              </button>
                              

                                      </td>
                                  </tr>

                                  <?php

                              }
                              }
                              else 
                              {
                                  ?>
                                  <tr>
                                      <td colspan='5' class='text-center'>No Record Found</td>
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

                                  var user_id = $(this).val();
                                  $('.delete_user_id').val(user_id);
                                  $('#DeleteModal').modal('show');
                                });
                               });
                              </script>

                              <script>
                               $(document).ready(function (){
                                $('.approvebtn').click(function (e) {
                                  e.preventDefault();

                                  var staffid = $(this).val();
                                  $('.approve_staff_id').val(staffid);
                                  $('#ApproveModal').modal('show');
                                });
                               });
                              </script>


<?php include('assets/includes/footer.php'); ?>
                
                             

