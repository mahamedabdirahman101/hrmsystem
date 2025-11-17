<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container mt-3">
  <h2>Striped Rows</h2>
  <p>The .table-striped class adds zebra-stripes to a table:</p>            
  <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                              <th>Id</th>
                              <th>Name</th>
                              <th>Leave Type</th>
                            </tr>
                            </thead>
                            <tbody>

 <?php
                              // $diff = "SELECT DATEDIFF(`end_date`, `start_date`) AS daysforleave FROM leave_requests";
                              

                              $query = "SELECT s.* FROM staff s JOIN `departments` d ON s.id = d.id WHERE d.name = 'Department X';";
                              $query_run = mysqli_query($con,$query);

                              if(mysqli_num_rows($query_run) > 0)
                              {

                                

                                  foreach($query_run as $staff_info)
                              {
                                
                                  ?>
    
      <tr>
        <td>Name</td>
        <td>Doe</td>
        <td>john@example.com</td>
      </tr>
      <tr>
        <td>Mary</td>
        <td>Moe</td>
        <td>mary@example.com</td>
      </tr>
      <tr>
        <td>July</td>
        <td>Dooley</td>
        <td>july@example.com</td>
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
  </table>
</div>




</body>
</html>