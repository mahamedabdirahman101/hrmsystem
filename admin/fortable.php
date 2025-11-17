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
                              $query = "SELECT * FROM `staffs`";
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
                                         <button type="button" value="<?= $staff_info['id']; ?>" class="btn btn-sm btn-danger deletebtn">
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