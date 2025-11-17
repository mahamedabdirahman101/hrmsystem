<?php
include('authentication.php');
include('assets/includes/header.php');
include('assets/includes/sideForAdmin.php');
include('assets/includes/topbar.php');
?>
 
 
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
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
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-4">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">

            <?php
                                                                if(isset($_GET['dept_id']))
                                                                {
                                                                    $dept_id =  $_GET['dept_id'];
                                                                    $query = "SELECT * FROM `departments` WHERE `id`='$dept_id' LIMIT 1";
                                                                    $query_run = mysqli_query($con, $query);

                                                                    if(mysqli_num_rows($query_run) > 0)
                                                                    {
                                                                        foreach($query_run as $dept_info)
                                                                        {
                                                                            ?>
                                    <div class="card-body box-profile">
                                        <div class="text-center">
                                        <!-- <img class="profile-user-img img-fluid img-circle"
                                            src="assets/dist/img/staff/mohe.jpg"
                                            alt="User profile picture"> -->
                                            <!-- <img class="profile-user-img img-fluid img-circle" src="uploads/staff/<?= $dept_info['photo']; ?>" width="50px" height="50px" alt="image"> -->
                                        </div>

                                       

                                        

                                        <ul class="list-group list-group-unbordered mb-3">
                                        <li class="list-group-item">
                                            <b>Department</b> <a class="float-right"><?= $dept_info['name']; ?></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Category</b> <a class="float-right"><?= $dept_info['category']; ?></a>
                                        </li>
                                        
                                        </ul>

                                        <!-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> -->
                                    </div>
                                  
                               
              
              <!-- /.card-body -->
                 
            </div>
            <!-- /.card -->

            

            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">About</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong><i class="fas fa-book mr-1"></i> Director</strong>

                <p class="text-muted">
                <?= $dept_info['director']; ?>
                </p>

                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Overview</strong>

                <p class="text-muted"><?= $dept_info['overview']; ?></p>

                <hr>

                <strong><i class="fas fa-pencil-alt mr-1"></i> No_ of Staffs</strong>

                <p class="text-muted">
                <?= $dept_info['no_staffs']; ?>
                </p>

                <hr>

                <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>

                <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
              </div>
              <a href="staffs-edit.php?dept_id=<?= $dept_id['id']; ?>"type="button" class="btn btn-sm btn-info" data-dismiss="modal"><i class="fa fa-edit"></i>Edit</a>
              <!-- /.card-body -->

               
            <!-- /.card -->
          </div>
          <!-- /.col -->
         
          <!-- /.col -->
           
        </div>

         
        <!-- /.row -->
      </div><!-- /.container-fluid -->

      

      
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php 
                                      
                                    }
                                  }         
                                }
      
                                            ?>

  <?php include('assets/includes/footer.php'); ?>
<?php include('assets/includes/script.php'); ?>


   