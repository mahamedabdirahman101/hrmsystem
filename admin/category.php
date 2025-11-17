<?php
include('authentication.php');
include('assets/includes/header.php');
include('assets/includes/sideForAdmin.php');
include('assets/includes/topbar.php');
?>




<!-- Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Gift Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

        <form action="code.php" method="POST">
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Category Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="">Description</label>
                    <textarea name="desc" rows="" class="form-control" required></textarea>
                </div>

                <div class="form-group">
                    <label for="">Trending</label>
                    <input type="checkbox" name="trending"> Trending
                </div>

                <div class="form-group">
                    <label for="">Status</label>
                    <input type="checkbox" name="status"> Status
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                <button type="submit" name="category_save" class="btn btn-success">Save</button>
            </div>
        </form>

    </div>
  </div>
</div>


 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <section class="content mt-4">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php include('message.php'); ?>
                    <div class="card">
                        <div class="card-header">
                            <h4>
                                Gift Category
                                <a href="#" data-toggle="modal" data-target="#categoryModal" class="btn btn-primary float-right">Add</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Trending</th>
                                        <th>Status</th>
                                        <th>Created_at</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php
                                $query = "SELECT * FROM categories";
                                $query_run = mysqli_query($con, $query);
                                if(mysqli_num_rows($query_run) > 0 )
                                {
                                    foreach($query_run as $cateitem)
                                    {
                                        ?>
                                    <tr>
                                        <td><?= $cateitem['id']; ?></td>
                                        <td><?= $cateitem['name']; ?></td>
                                        <td>
                                            <input type="checkbox" <?= $cateitem['trending'] == '1' ? 'checked': ''; ?> readonly />
                                        </td>
                                        <td>
                                            <input type="checkbox" <?= $cateitem['status'] == '1' ? 'checked': ''; ?> readonly />
                                        </td>
                                        <td><?= $cateitem['created_at']; ?></td>
                                        <td>
                                        <a href="category-edit.php?id=<?= $cateitem['id']; ?>" class="btn btn-warning">Edit</a>
                                        <a href="" class="btn btn-danger">Delete</a>
                                    </td>
                                     
                                    </tr> 

                                        <?php
                                    }
                                }
                                else {
                                    ?>
                                    <tr>
                                        <td colspan="7">NO DATA FOUND</td>
                                    </tr>
                                    <?php
                                }
                                

                                    ?>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
 </div>
 <?php include('assets/includes/footer.php'); ?>
<?php include('assets/includes/script.php'); ?>