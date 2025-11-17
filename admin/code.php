<?php
    include('authentication.php');
    include('config/dbcon.php');

   if (isset($_POST['updateStaffs'])) {
    include('config/dbcon.php');

    $staffs_id     = $_POST['staffs_id'];
    $name          = trim($_POST['name']);
    $department    = trim($_POST['department']);
    $position      = trim($_POST['position']);
    $gender        = trim($_POST['gender']);  // ✅ NEW
    $title         = trim($_POST['title']);
    $education     = trim($_POST['education']);
    $address       = trim($_POST['address']);
    $date          = trim($_POST['date']);
    $skills        = trim($_POST['skills']);

    $old_image     = $_POST['old_photo'];
    $old_documents = $_POST['old_documents'];
    $documents     = $_FILES['documents'];
    $image         = $_FILES['photo'];

    // ========== IMAGE UPLOAD ==========
    $update_image = $old_image;
    if (!empty($image['name'])) {
        $img_ext = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png'];
        if (in_array($img_ext, $allowed_ext)) {
            $img_name = uniqid() . "_staff." . $img_ext;
            move_uploaded_file($image['tmp_name'], "uploads/staff/" . $img_name);
            if (!empty($old_image) && file_exists("uploads/staff/" . $old_image)) {
                unlink("uploads/staff/" . $old_image);
            }
            $update_image = $img_name;
        }
    }

    // ========== DOCUMENT UPLOAD ==========
    $uploaded_docs = [];
    $allowed_doc_ext = ['pdf'];
    foreach ($documents['name'] as $index => $doc_name) {
        $doc_tmp = $documents['tmp_name'][$index];
        $doc_ext = strtolower(pathinfo($doc_name, PATHINFO_EXTENSION));
        if (!empty($doc_name) && in_array($doc_ext, $allowed_doc_ext)) {
            $doc_new = uniqid() . "_doc$index." . $doc_ext;
            move_uploaded_file($doc_tmp, "uploads/docs/" . $doc_new);
            $uploaded_docs[] = $doc_new;
        }
    }

    $update_documents = (!empty($uploaded_docs)) ? implode(",", $uploaded_docs) : $old_documents;

    // ========== UPDATE QUERY ==========
    $query = "UPDATE staff SET 
        name = ?, 
        department = ?, 
        position = ?, 
        gender = ?, 
        title = ?, 
        education = ?, 
        address = ?, 
        date = ?, 
        photo = ?, 
        skills = ?, 
        documents = ?
        WHERE id = ?";

    $stmt = mysqli_prepare($con, $query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssssssssssi", 
            $name, $department, $position, $gender, $title, $education, 
            $address, $date, $update_image, $skills, $update_documents, $staffs_id);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['status'] = "Staff updated successfully!";
        } else {
            $_SESSION['status'] = "Update failed: " . mysqli_error($con);
        }
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['status'] = "Database error: " . mysqli_error($con);
    }

    header("Location: staff.php");
    exit();
}


    if(isset($_POST['updateStaff']))
    {

        $staffs_id            =     $_POST['staffs_id'];
        $name                =      $_POST['name'];
        $department          =      $_POST['department'];
        $position            =      $_POST['position'];
        $title               =      $_POST['title'];
        $education           =      $_POST['education'];
        $address             =      $_POST['address'];
        $date                 =      $_POST['date'];
        $skills              =      $_POST['skills'];


       
        $image               =      $_FILES['photo']['name'];
        $documents           =      $_FILES['documents']['name'];
        $old_image           =      $_POST['old_photo'];
        $old_documents           =      $_POST['old_documents'];

        if($image != '')
        {
            $update_filename = $_FILES['photo']['name'];
            $$update_file  = $_FILES['documents']['name'];

            $allowed_extension = array('png','jpg','jpeg','pdf','word');
            $file_extension = pathinfo($update_filename, PATHINFO_EXTENSION);

            $filename = time().'.'.$file_extension;
            if(!in_array($file_extension,$allowed_extension))
            {
                $_SESSION['status'] = "you are allowed with only jpg,png and jpeg images!!!";
                header('Location: staff.php');
                exit(0);


            }
            $update_filename = $filename;
          
            $update_file     = $file;
            
            }

        else 
        {
            $update_filename = $old_image;
            $update_file     = $old_documents;
            
        }
   
        

        // if($documents != '')
        // {

        //     $update_file = $_FILES['documents']['name'];

        //     $allowed_extension = array('pdf','word');
        //     $file_extension_for_document = pathinfo($update_file, PATHINFO_EXTENSION);

        //     $file = time().'.'.$file_extension_for_document;
        //     if(!in_array($file_extension_for_document,$allowed_extension))
        //     {
        //         $_SESSION['status'] = "you are allowed with only pdf documents!!!";
        //         header('Location: staff.php');
        //         exit(0);


        //     }
    
        //     $update_file     = $file;
        //     }

        // else 
        // {
            
        //     $update_file     = $old_documents;
        // }
       
     

        $query = "UPDATE `staffs` SET `name` = '$name', 
        `department` = '$department',
        `position` = ' $position', 
        `title` = '$title', 
        `education` = '$education', 
        `address` = '$address', 
        `date` = '$date',
        `photo` = '$update_filename',
        `skills`='$skills' ,
        `documents` = '$update_file'
        WHERE `staffs`.`id` = '$staffs_id'";


        $query_run = mysqli_query($con,$query);

        if($query_run)
        {
            if($image != '')
        {
            move_uploaded_file($_FILES['documents']['tmp_name'], 'uploads/docs/'.$file);
            move_uploaded_file($_FILES['photo']['tmp_name'], 'uploads/staff/'.$filename);
            if(file_exists('uploads/staff/'.$old_image) )
            {
                unlink("uploads/staff/".$old_image);
                unlink("uploads/docs/".$old_documents);
            } 
        }
       

        $_SESSION['status'] = "Staff Updated Successfully!";
        header('Location: staff.php?staff_id='.$staffs_id);
        exit(0);

        }

      

        else 
        {
            $_SESSION['status'] = "Staff Not Updated!";
            header('Location: staff.php?staff_id='.$staffs_id);
            exit(0);
    

        }
        


    }




    if(isset($_POST['product_update']))
    {
        $product_id         = $_POST['product_id'];
        $category_id        = $_POST['category_id'];
        $name               = $_POST['name'];
        $small_description  = $_POST['small_description'];
        $long_description   = $_POST['long_description'];
        $price              = $_POST['price'];
        $offerprice         = $_POST['offerprice'];
        $tax                = $_POST['tax'];
        $quantity           = $_POST['quantity'];
        $status             = $_POST['status'] == true ? '1' : '0';

        $image = $_FILES['image']['name'];
        $old_image = $_POST['old_image'];

        if($image != '')
        {
            $update_filename = $_FILES['image']['name'];

            $allowed_extension = array('png','jpg','jpeg','pdf','word');
            $file_extension = pathinfo($update_filename, PATHINFO_EXTENSION);

            $filename = time().'.'.$file_extension;
            if(!in_array($file_extension,$allowed_extension))
            {
                $_SESSION['status'] = "you are allowed with only jpg,png and jpeg images!!!";
                header('Location: product-add.php');
                exit(0);


            }
            $update_filename = $filename;
            }

        else 
        {
            $update_filename = $old_image;
        }


     

        $query = "UPDATE `products` SET `category_id`='$category_id', 
        `name` = '$name', 
        `small_description` = '$small_description',
        `long_description` = ' $long_description', 
        `price` = '$price', 
        `offerprice` = '$offerprice', 
        `tax` = '$tax', 
        `quantity` = '$quantity',
        `image` = '$update_filename',
        `status`='$status' 
        WHERE `products`.`id` = '$product_id'";


        $query_run = mysqli_query($con,$query);

        if($query_run)
        {
            if($image != '')
        {
            move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/product/'.$filename);
            if(file_exists('uploads/product/'.$old_image))
            {
                unlink("uploads/product/".$old_image);
            }
        }
       

        $_SESSION['status'] = "Product Updated Successfully!";
        header('Location: product-edit.php?prod_id='.$product_id);
        exit(0);

        }
        else 
        {
            $_SESSION['status'] = "Product Not Updated!";
            header('Location: product-edit.php?prod_id='.$product_id);
            exit(0);
    

        }
        


    }




    if(isset($_POST['product_save']))
    {
        $category_id = $_POST['category_id'];
        $name = $_POST['name'];
        $small_description = $_POST['small_description'];
        $long_description = $_POST['long_description'];
        $price = $_POST['price'];
        $offerprice = $_POST['offerprice'];
        $tax = $_POST['tax'];
        $quantity = $_POST['quantity'];
        $status = $_POST['status'] == true ? '1' : '0';
        $image = $_FILES['image']['name'];

        $allowed_extension = array('png','jpg','jpeg','pdf','word');
        $file_extension = pathinfo($image, PATHINFO_EXTENSION);

        $filename = time().'.'.$file_extension;
        if(!in_array($file_extension,$allowed_extension))
        {
            $_SESSION['status'] = "you are allowed with only jpg,png and jpeg images!!!";
            header('Location: product-add.php');
            exit(0);

        }

        else 
        {
            $query = "INSERT INTO products (category_id,name,small_description,long_description,price,offerprice,tax,quantity,image,status) 
            VALUES ('$category_id','$name','$small_description','$long_description','$price','$offerprice',
            '$tax','$quantity','$filename','$status')";

            

            $query_run = mysqli_query($con,$query);
            if($query_run)
            {
                move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/product/'.$filename);

                $_SESSION['status'] = "Product Added Successfully!";
                header('Location: product-add.php');
                exit(0);
            }

            else 
            {
                $_SESSION['status'] = "Something went wrong!";
                header('Location: product-add.php');
                exit(0);
            }
        }

    }



    if(isset($_POST['category_save']))
    {
        $name           = $_POST['name'];
        $description    = $_POST['desc'];
        $trending       = $_POST['trending'] == true ? '1': '0';
        $status         = $_POST['status']  == true ? '1': '0';
        



        // $query = "UPDATE `users` SET name='$name', phone='$phone', email='$email', password='$pass' WHERE `id`='$user_id'";
        $category_query = "INSERT INTO categories (name,description,trending,status) 
                VALUES ('$name','$description','$trending', '$status')";
        $category_query_run = mysqli_query($con, $category_query);

        if($category_query_run)
        {
            $_SESSION['status']  = "Category Insertion Successfully!";
            header('Location: category.php');
        }
        else 
        {
            $_SESSION['status']  = "Category Insertion Failed!";
            header('Location: category.php');
        }

    }

    if(isset($_POST['category_update']))
    {
        $cate_id = $_POST['cate_id'];
        $name = $_POST['name'];
        $description = $_POST['desc'];
        $trending = $_POST['trending'] == true ? '1' : '0';
        $status = $_POST['status'] == true ? '1' : '0';

        $query = "UPDATE categories SET name='$name', description='description',trending='$trending', status='$status' WHERE id='$cate_id'";
        $query_run = mysqli_query($con, $query);

        if($query_run)
        {
            $_SESSION['status']  = "Category Updated Successfully!";
            header('Location: category.php');
        }
        else 
        {
            $_SESSION['status']  = "Category Update Failed!";
            header('Location: category.php');
        }
    }
















    if(isset($_POST['logout_btn']))
    {
        //session_destroy();
        unset($_SESSION['auth']);
        unset($_SESSION['auth_status']);


        $_SESSION['status'] = "Logged Out Successfully!";
        header('Location: login.php');
        exit(0);
    } 
    if(isset($_POST['check_Emailbtn']))
    {

        $email = $_POST['email'];
        $checkmail = "SELECT email FROM users WHERE email='$email'";
        $checkmail_run = mysqli_query($con, $checkmail);

        if(mysqli_num_rows($checkmail_run) > 0) 
        {
            echo 'Email Id Already Taken!';
        }

        else 

        {
            echo 'It\'s Available';
        }
    }
    else
    {

    }

 
if (isset($_POST['addStaffs'])) {
    

    $name       = trim($_POST['name']);
    $department = trim($_POST['deptName']);
    $position   = trim($_POST['position']);
    $gender     = trim($_POST['gender']);
    $title      = trim($_POST['title']);
    $education  = trim($_POST['education']);
    $address    = trim($_POST['address']);
    $phone      = trim($_POST['phone']);
    $date       = trim($_POST['date']);
    $skills     = trim($_POST['skills']);

    // Validate required fields
    if (empty($name) || empty($department) || empty($position) || empty($date)) {
        $_SESSION['status'] = "Please fill in all required fields.";
        header("Location: staff.php");
        exit();
    }

    // ===== IMAGE UPLOAD =====
    $image = $_FILES['photo'];
    $image_name = $image['name'];
    $image_tmp = $image['tmp_name'];
    $image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
    $allowed_img_ext = ['png', 'jpg', 'jpeg'];

    if (!in_array($image_ext, $allowed_img_ext)) {
        $_SESSION['status'] = "Only JPG, PNG, and JPEG images are allowed.";
        header("Location: staff.php");
        exit();
    }

    $unique_id = uniqid();
    $new_image_name = $unique_id . "_photo." . $image_ext;
    $image_dest = "uploads/staff/" . $new_image_name;
    move_uploaded_file($image_tmp, $image_dest);

    // ===== DOCUMENT UPLOAD =====
    $documents = $_FILES['documents'];
    $uploaded_docs = [];
    $allowed_doc_ext = ['pdf'];

    foreach ($documents['name'] as $index => $doc_name) {
        $doc_tmp = $documents['tmp_name'][$index];
        $doc_ext = strtolower(pathinfo($doc_name, PATHINFO_EXTENSION));

        if (!in_array($doc_ext, $allowed_doc_ext)) {
            $_SESSION['status'] = "Only PDF documents are allowed.";
            header("Location: staff.php");
            exit();
        }

        $new_doc_name = $unique_id . "_doc$index." . $doc_ext;
        $doc_dest = "uploads/docs/" . $new_doc_name;

        if (move_uploaded_file($doc_tmp, $doc_dest)) {
            $uploaded_docs[] = $new_doc_name;
        } else {
            error_log("Document upload failed: $doc_name");
        }
    }

    $document_filenames = implode(',', $uploaded_docs); // Comma-separated filenames

    // ===== INSERT STAFF INTO DATABASE =====
    $query = "INSERT INTO staff (name, photo, department, position, gender, title, education, address, phone, date, skills, documents)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($con, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssssssssssss", $name, $new_image_name, $department, $position, $gender, $title, $education, $address, $phone, $date, $skills, $document_filenames);
        $execute = mysqli_stmt_execute($stmt);

        if ($execute) {
            $_SESSION['status'] = "Staff added successfully!";

            // ===== INSERT NOTIFICATION =====
            $notif_msg = "New staff member <strong>" . htmlspecialchars($name) . "</strong> has been added.";
            $notif_query = "INSERT INTO notifications (type, message, is_read) VALUES ('staff', ?, 0)";
            $notif_stmt = mysqli_prepare($con, $notif_query);
            mysqli_stmt_bind_param($notif_stmt, "s", $notif_msg);
            mysqli_stmt_execute($notif_stmt);
            mysqli_stmt_close($notif_stmt);

        } else {
            $_SESSION['status'] = "Failed to insert staff.";
        }

        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['status'] = "Database error!";
    }

    header("Location: staff.php");
    exit();
}





       



// INSERT DISCIPLINE RECORD
if (isset($_POST['save_discipline'])) {
    $staff_id = intval($_POST['staff_id']);
    $offense_type = trim($_POST['offense_type']);
    $description = trim($_POST['description']);
    $date_reported = $_POST['date_reported'];
    $action_taken = trim($_POST['action_taken']);
    $status = trim($_POST['status']);
    $recorded_by = $_SESSION['auth_user']['user_id'] ?? null;

    if (!$staff_id || !$offense_type || !$description || !$date_reported || !$status || !$recorded_by) {
        $_SESSION['status'] = "All fields are required.";
        header('Location: discipline_records.php');
        exit();
    }

    $query = "INSERT INTO discipline_records 
              (staff_id, offense_type, description, date_reported, action_taken, recorded_by, status) 
              VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $con->prepare($query);
    if ($stmt) {
        $stmt->bind_param("issssis", $staff_id, $offense_type, $description, $date_reported, $action_taken, $recorded_by, $status);
        if ($stmt->execute()) {
            $last_id = $stmt->insert_id;
            $_SESSION['status'] = "Record Registered Successfully!";
            header("Location: recordProfile.php?record_id=$last_id");
            exit();
        } else {
            $_SESSION['status'] = "Insert failed: " . $stmt->error;
            header("Location: discipline_records.php");
            exit();
        }
    } else {
        $_SESSION['status'] = "Error preparing query: " . $con->error;
        header("Location: discipline_records.php");
        exit();
    }
}

// DELETE DISCIPLINE RECORD
if (isset($_POST['DeleteRecordbtn'])) {
    $record_id = intval($_POST['delete_id']);

    $query = "DELETE FROM discipline_records WHERE id = ?";
    $stmt = $con->prepare($query);
    if ($stmt) {
        $stmt->bind_param("i", $record_id);
        if ($stmt->execute()) {
            $_SESSION['status'] = "Record Deleted Successfully!";
        } else {
            $_SESSION['status'] = "Failed to delete record.";
        }
    } else {
        $_SESSION['status'] = "Delete query failed: " . $con->error;
    }
    header('Location: discipline_records.php');
    exit();
}


if (isset($_POST['update_discipline'])) {
    $record_id = $_POST['record_id'];
    $offense_type = mysqli_real_escape_string($con, $_POST['offense_type']);
    $date_reported = mysqli_real_escape_string($con, $_POST['date_reported']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $action_taken = mysqli_real_escape_string($con, $_POST['action_taken']);
    $status = mysqli_real_escape_string($con, $_POST['status']);

    // Fetch the current discipline record (along with staff_id)
    $fetch_query = "SELECT * FROM discipline_records WHERE id = '$record_id' LIMIT 1";
    $fetch_result = mysqli_query($con, $fetch_query);

    if (mysqli_num_rows($fetch_result) > 0) {
        $record = mysqli_fetch_assoc($fetch_result);

        // Update the original record
        $update_query = "UPDATE discipline_records 
                         SET offense_type='$offense_type', date_reported='$date_reported', 
                             description='$description', action_taken='$action_taken', status='$status' 
                         WHERE id='$record_id'";
        $update_result = mysqli_query($con, $update_query);

        if ($update_result) {
            // If status is "Resolved", insert into resolved_discipline
            if ($status === "Resolved") {
                $staff_id = $record['staff_id'];

                $insert_resolved = "INSERT INTO resolved_discipline 
                    (staff_id, offense_type, date_reported, description, action_taken, status) 
                    VALUES ('$staff_id', '$offense_type', '$date_reported', '$description', '$action_taken', 'Resolved')";

                $resolved_result = mysqli_query($con, $insert_resolved);

                if ($resolved_result) {
                    // Optional: Delete from discipline_records
                    $delete_original = "DELETE FROM discipline_records WHERE id='$record_id'";
                    mysqli_query($con, $delete_original);

                    $_SESSION['message'] = "Discipline record resolved and moved to resolved_discipline table.";
                } else {
                    $_SESSION['message'] = "Record updated, but failed to insert into resolved_discipline.";
                }
            } else {
                $_SESSION['message'] = "Discipline record updated successfully.";
            }
        } else {
            $_SESSION['message'] = "Failed to update discipline record.";
        }
    } else {
        $_SESSION['message'] = "Record not found.";
    }

    header("Location: discipline_records.php");
    exit(0);
}




if (isset($_POST['addLeave'])) {
    include('config/dbcon.php');

    $staff_id   = mysqli_real_escape_string($con, $_POST['staff_id']);
    $leaveType  = mysqli_real_escape_string($con, $_POST['leavetype']);
    $startDate  = mysqli_real_escape_string($con, $_POST['startdate']);
    $endDate    = mysqli_real_escape_string($con, $_POST['enddate']);
    $status     = mysqli_real_escape_string($con, $_POST['status']);
    $reason     = mysqli_real_escape_string($con, $_POST['reason']);

    if (empty($staff_id) || empty($leaveType) || empty($startDate) || empty($endDate) || empty($status) || empty($reason)) {
        $_SESSION['status'] = "All fields are required!";
        header("Location: leave.php");
        exit(0);
    }

    $query = "INSERT INTO `leave` (staff_id, leave_type, start_date, end_date, status, reason) 
              VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($con, $query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "isssss", $staff_id, $leaveType, $startDate, $endDate, $status, $reason);
        $run = mysqli_stmt_execute($stmt);
        
        if ($run) {
            $_SESSION['status'] = "Leave Request Added Successfully!";
        } else {
            $_SESSION['status'] = "Failed to add leave request! Error: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['status'] = "Database prepare error: " . mysqli_error($con);
    }

    header("Location: leave.php");
    exit(0);
}



if (isset($_POST['addAttendance'])) {
    include('config/dbcon.php');

    $staff_id     = mysqli_real_escape_string($con, $_POST['staff_id']);
    $month        = mysqli_real_escape_string($con, $_POST['date']);
    $daysPresent  = (int) $_POST['days_present'];
    $daysAbsent  = (int) $_POST['days_absent'];
    $totalDays    = (int) $_POST['total_days'];
    $created_at   = date('Y-m-d H:i:s');

    if (empty($staff_id) || empty($month) || $daysPresent < 0 || $totalDays <= 0) {
        $_SESSION['status'] = "All fields are required and must be valid!";
        header("Location: attendance_summary.php");
        exit(0);
    }

    // Calculate the attendance percentage
    $percentage = ($daysPresent / $totalDays) * 100;
    $percentage = round($percentage, 2); // Optional: round to 2 decimal places

    // Prepare the SQL statement
    $query = "INSERT INTO `attendance_summary` (staff_id, date, present_days, absent_days, total_days, percentage, created_at) 
              VALUES (?, ?, ?, ?,?, ?, ?)";

    $stmt = mysqli_prepare($con, $query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "isiiiis", $staff_id, $month, $daysPresent,$daysAbsent, $totalDays, $percentage, $created_at);
        $run = mysqli_stmt_execute($stmt);
        
        if ($run) {
            $_SESSION['status'] = "Attendance Added Successfully!";
        } else {
            $_SESSION['status'] = "Failed to add attendance! Error: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['status'] = "Database prepare error: " . mysqli_error($con);
    }

    header("Location: attendance_summary.php");
    exit(0);
}




// ADD Performance Review
if (isset($_POST['addPerformance'])) {
    $staff_id = mysqli_real_escape_string($con, $_POST['staff_id']);
    $review_period = mysqli_real_escape_string($con, $_POST['reviewperiod']);
    $score = (int) $_POST['score'];
    $remarks = mysqli_real_escape_string($con, $_POST['remarks']);
    $review_date = mysqli_real_escape_string($con, $_POST['review_date']);

    if ($staff_id != '' && $review_period != '' && $remarks != '' && $review_date != '') {
        $query = "INSERT INTO performance_records (staff_id, review_period, score, remarks, review_date)
                  VALUES ('$staff_id', '$review_period', '$score', '$remarks', '$review_date')";
        $query_run = mysqli_query($con, $query);

        if ($query_run) {
            $_SESSION['status'] = "Performance review added successfully.";
            header("Location: performance_review.php");
            exit(0);
        } else {
            $_SESSION['alert'] = "Failed to add performance review.";
            header("Location: performance_review.php");
            exit(0);
        }
    } else {
        $_SESSION['alert'] = "All fields are required.";
        header("Location: performance_review.php");
        exit(0);
    }
}










if (isset($_POST['updateLeave'])) {
    include('config/dbcon.php');

    $leave_id   = mysqli_real_escape_string($con, $_POST['leave_id']);
    $leave_type = mysqli_real_escape_string($con, $_POST['leavetype']);
    $start_date = mysqli_real_escape_string($con, $_POST['startdate']);
    $end_date   = mysqli_real_escape_string($con, $_POST['enddate']);
    $status     = mysqli_real_escape_string($con, $_POST['status']);
    $old_doc    = $_POST['old_document'];

    // Handle document upload
    $new_doc_name = $old_doc;

    if (!empty($_FILES['document']['name'])) {
        $doc_file = $_FILES['document'];
        $doc_name = $doc_file['name'];
        $doc_tmp  = $doc_file['tmp_name'];
        $doc_ext  = strtolower(pathinfo($doc_name, PATHINFO_EXTENSION));

        if (!in_array($doc_ext, ['pdf'])) {
            $_SESSION['status'] = "Only PDF documents are allowed.";
            header("Location: leave-edit.php?leave_id=$leave_id");
            exit();
        }

        $new_doc_name = uniqid("leave_", true) . ".$doc_ext";
        $upload_path  = "uploads/leaveDocuments/" . $new_doc_name;

        if (move_uploaded_file($doc_tmp, $upload_path)) {
            if (!empty($old_doc) && file_exists("uploads/leaveDocuments/$old_doc")) {
                unlink("uploads/leaveDocuments/$old_doc");
            }
        } else {
            $_SESSION['status'] = "Failed to upload document.";
            header("Location: leave-edit.php?leave_id=$leave_id");
            exit();
        }
    }

    // Get staff_id for transfer
    $get_staff = mysqli_query($con, "SELECT staff_id FROM `leave` WHERE leave_id = '$leave_id' LIMIT 1");
    if ($get_staff && mysqli_num_rows($get_staff) > 0) {
        $staff_data = mysqli_fetch_assoc($get_staff);
        $staff_id = $staff_data['staff_id'];
    } else {
        $_SESSION['status'] = "Invalid leave ID.";
        header("Location: leave.php");
        exit();
    }

    // Determine destination table
    if ($status === "Approved") {
        $insert = "INSERT INTO approved_leaves (leave_id, staff_id, leave_type, start_date, end_date, status, documents)
                   VALUES (?, ?, ?, ?, ?, ?, ?)";
    } elseif ($status === "Cancelled") {
        $insert = "INSERT INTO cancelled_leaves (leave_id, staff_id, leave_type, start_date, end_date, status, documents)
                   VALUES (?, ?, ?, ?, ?, ?, ?)";
    } else {
        // If status is still pending, just update and return
        $update_query = "UPDATE `leave` SET 
                         leave_type = ?, start_date = ?, end_date = ?, status = ?, documents = ?
                         WHERE leave_id = ?";
        $stmt = mysqli_prepare($con, $update_query);
        mysqli_stmt_bind_param($stmt, "sssssi", $leave_type, $start_date, $end_date, $status, $new_doc_name, $leave_id);
        mysqli_stmt_execute($stmt);

        $_SESSION['status'] = "Leave updated as Pending.";
        header("Location: leave.php");
        exit();
    }

    // Insert into destination table
    $stmt = mysqli_prepare($con, $insert);
    mysqli_stmt_bind_param($stmt, "iisssss", $leave_id, $staff_id, $leave_type, $start_date, $end_date, $status, $new_doc_name);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        // Delete from original table
        $delete = mysqli_query($con, "DELETE FROM `leave` WHERE leave_id = '$leave_id'");

        $_SESSION['status'] = "Leave $status and moved successfully!";
    } else {
        $_SESSION['status'] = "Insert to $status table failed: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
    header("Location: leave.php");
    exit();
}


        

    

    if(isset($_POST['addUser']))
    {
        $name =                      $_POST['name'];
        $phone =                     $_POST['phone'];
        $email =                     $_POST['email'];
        $password =                  $_POST['password'];
        $confirmpassword =           $_POST['confirmpassword'];
        $role_as =                   $_POST['role_as'];






        if($password == $confirmpassword)
        {

            $checkmail = "SELECT email FROM users WHERE email='$email'";
            $checkmail_run = mysqli_query($con, $checkmail);

            if(mysqli_num_rows($checkmail_run) > 0) 
            {
                $_SESSION['alert']  = "Email Taken Already!";
                header('Location: registered.php');
                exit;
            }

            else 

            {
                $user_query = "INSERT INTO users (name,phone,email,password,role) 
                VALUES ('$name','$phone','$email',md5('$password'),'$role_as')";
        
        
        
                $user_query_run = mysqli_query($con, $user_query);
        
                if($user_query_run)
                {
                    $_SESSION['status']  = "User Added Successfully!";
                    header('Location: registered.php');
                }
                else 
                {
                    $_SESSION['status']  = "<h4 class='alert alert-danger alert-dismissible fade'>User Registration Failed!</h4>";
                    header('Location: registered.php');
                }
            }
           

        }

        else 
        {
                  $_SESSION['alert']  = "Password Don't Match!";
                header('Location: registered.php');
        }

        

    }


    if(isset($_POST['updateUser']))
    {
        $user_id = $_POST['id'];
        $name    = $_POST['name'];
        $phone   = $_POST['phone'];
        $email   = $_POST['email'];
        $pass    = $_POST['password'];
        $role_as    = $_POST['role_as'];



        // $query = "UPDATE `users` SET name='$name', phone='$phone', email='$email', password='$pass' WHERE `id`='$user_id'";

        $query  = "UPDATE users SET name='$name', phone='$phone', email='$email', password=md5('$pass'), role ='$role_as' WHERE id='$user_id'";
        $query_run = mysqli_query($con, $query);

        if($query_run)
        {
            $_SESSION['status']  = "User Updated Successfully!";
            header('Location: registered.php');
        }
        else 
        {
            $_SESSION['status']  = "<h4 class='alert alert-danger alert-dismissible fade'>User Updating Failed!</h4>";
            header('Location: registered.php');
        }

    }

  if (isset($_POST['addDepartment'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $category = mysqli_real_escape_string($con, $_POST['category']);
    $director = mysqli_real_escape_string($con, $_POST['director']);
    $overview = mysqli_real_escape_string($con, $_POST['overview']);

    $query = "INSERT INTO departments (name, category, director, overview) VALUES ('$name', '$category', '$director', '$overview')";
    $query_run = mysqli_query($con, $query);

    if ($query_run) {
        $_SESSION['status'] = "Department Added Successfully!";
    } else {
        $_SESSION['status'] = "Department Add Failed!";
    }

    header('Location: departments.php');
    exit(0);
}

           

            if(isset($_POST['DeleteDepartment']))
            {
                $deptid = $_POST['delete_dept'];
                // $name    = $_POST['name'];
                // $phone   = $_POST['phone'];
                // $email   = $_POST['email'];
                // $pass    = $_POST['password'];
        
        
        
                // $query = "UPDATE `users` SET name='$name', phone='$phone', email='$email', password='$pass' WHERE `id`='$user_id'";
        
                $query  = "DELETE FROM departments WHERE id='$deptid'";
                $query_run = mysqli_query($con, $query);
        
                if($query_run)
                {
                    $_SESSION['status']  = "Department Deleted Successfully!";
                    header('Location: departments.php');
                }
                else 
                {
                    $_SESSION['status']  = "<h4 class='alert alert-danger alert-dismissible fade'>Department Deleting Failed!</h4>";
                    header('Location: departments.php');
                }
        
            }
   

        


      if (isset($_POST['updateDepts'])) {
    $dept_id  = $_POST['dept_id'];  // Corrected name
    $name     = trim($_POST['name']);
    $category = trim($_POST['category']);
    $director = trim($_POST['director']);
    $overview = trim($_POST['overview']);

    // Optional: Validate inputs
    if (empty($name) || empty($category) || empty($director) || empty($overview)) {
        $_SESSION['status'] = "Please fill in all required fields.";
        header('Location: departments.php');
        exit(0);
    }

    $query = "UPDATE `departments` 
              SET name = '$name', category = '$category', director = '$director', overview = '$overview' 
              WHERE id = '$dept_id'";
              
    $query_run = mysqli_query($con, $query);

    if ($query_run) {
        $_SESSION['status'] = "Department Updated Successfully!";
    } else {
        $_SESSION['status'] = "Department Updating Failed!";
    }

    header('Location: departments.php');
    exit(0);
}





    if(isset($_POST['updatesStaff']))
    {
        $staff_id  = $_POST['id'];
        $name      = $_POST['name'];
        $dept      = $_POST['department'];
        $pos       = $_POST['position'];
        $date      = $_POST['date'];
        



        // $query = "UPDATE `users` SET name='$name', phone='$phone', email='$email', password='$pass' WHERE `id`='$user_id'";

        $query  = "UPDATE `staff` SET name='$name', department='$dept', position='$pos', date='$date' WHERE id='$staff_id'";
        $query_run = mysqli_query($con, $query);

        if($query_run)
        {
            $_SESSION['status']  = "Staff Updated Successfully!";
            header('Location: staff.php');
        }
        else 
        {
            $_SESSION['status']  = "<h4 class='alert alert-danger alert-dismissible fade'>User Updating Failed!</h4>";
            header('Location: staff.php');
        }

    }

    if(isset($_POST['ApproveLeaves']))
    {
        $leave_id      = $_POST['reqId'];
        // $reqId         = $_POST['reqId'];
        $name          = $_POST['name'];
        $leaveType     = $_POST['leaveType'];
        $startDate     = $_POST['start_date'];
        $endDate       = $_POST['end_date'];
        $status        = $_POST['status'];
        $documents     = $_FILES['documents']['name'];
        



        // $query = "UPDATE `users` SET name='$name', phone='$phone', email='$email', password='$pass' WHERE `id`='$user_id'";

        // $query  = "UPDATE `staffs` SET name='$name', department='$dept', position='$pos', date='$date' WHERE id='$staff_id'";
        // $query ="INSERT INTO `approved_leaves` (`leave_id`,`name`,`leave_type`,`start_date`,`end_date`)
        // SELECT * FROM `leave_requests` WHERE `request_id`='$reqId'";

        $query = "INSERT INTO `approve_leave` (`leave_id`,`name`,`leave_type`,`start_date`,`end_date`) VALUES ('$leave_id','$name','$leaveType','$startDate','$endDate')";
        
        $query_run = mysqli_query($con, $query);

    

        if($query_run)
        {
            $_SESSION['status']  = "Leave Approved Successfully!";
            header('Location: leave.php');
        }
        else 
        {
            $_SESSION['status']  = "<h4 class='alert alert-danger alert-dismissible fade'>Leave Approve Failed!</h4>";
            header('Location: leave.php');
        }

    }



if (isset($_POST['ApproveLeave'])) {
    $leave_id = $_POST['reqId'];
    $name = $_POST['name'];
    $leaveType = $_POST['leavetype'];
    $startDate = $_POST['startdate'];
    $endDate = $_POST['enddate'];
    $status = $_POST['status'];
    $documents_name = $_FILES['documents']['name'];

    $allowed_extension = array('word', 'pdf', 'txt');
    $file_extension = pathinfo($documents_name, PATHINFO_EXTENSION);
    $file = time() . '.' . $file_extension;

    if (!in_array($file_extension, $allowed_extension)) {
        $_SESSION['status'] = "You are allowed only pdf, word, and txt files!!!";
        header('Location: leave.php');
        exit(0);
    } else {
        // 1. Begin Transaction (Important for data consistency)
        $con->begin_transaction();

        // 2. Prepared Statement for INSERT
        $stmt_insert = $con->prepare("INSERT INTO `approve_leave` (`leave_id`,`name`,`leave_type`,`start_date`,`end_date`,`status`,`documents`) VALUES (?, ?, ?, ?, ?, ?,?)");
        $stmt_insert->bind_param("issssss", $leave_id, $name, $leaveType, $startDate, $endDate, $status, $file);

        // 3. Prepared Statement for DELETE
        $stmt_delete = $con->prepare("DELETE FROM `leaves` WHERE `leave_id` = ?");
        $stmt_delete->bind_param("i", $leave_id);

        // 4. Execute Statements and Commit/Rollback
        if ($stmt_insert->execute() && $stmt_delete->execute()) {
            move_uploaded_file($_FILES['documents']['tmp_name'], 'uploads/leaveDocuments/' . $file);
            $con->commit(); // Commit the transaction
            $_SESSION['status'] = "Leave Request Added Successfully!";
            header('Location: leave.php');
            exit(0);
        } else {
            $con->rollback(); // Rollback on error
            $_SESSION['status'] = "<h4 class='alert alert-danger alert-dismissible fade'>Leave Request Registration Failed! Error: " . ($stmt_insert->error ? $stmt_insert->error : $stmt_delete->error) . "</h4>";
            header('Location: leave.php');
            exit(0);
        }

        $stmt_insert->close();
        $stmt_delete->close();
    }
}





if(isset($_POST['ApproveLeaveButton'])) {
    $leave_id    = $_POST['leave_id'];
    $name        = $_POST['name'];
    $dept        = $_POST['dept'];
    $leaveType   = $_POST['leavetype'];
    $startDate   = $_POST['startdate'];
    $endDate     = $_POST['enddate'];
    $status      = $_POST['status'];
    $documents   = $_FILES['documents']['name'];

    $allowed_extension = array('word','pdf','txt');

    $file_extension = pathinfo($documents, PATHINFO_EXTENSION);
    $file = time().'.'.$file_extension;

    if(!in_array($file_extension,$allowed_extension)) {
        $_SESSION['status'] = "You are allowed only pdf, word and txt files!";
        header('Location: leave.php');
        exit(0);
    } else {
        // 1. Database Connection (Important: Use prepared statements to prevent SQL injection!)
        $con = mysqli_connect("localhost", "root", "", "phpadminpanel"); // Replace with your credentials
        if (mysqli_connect_errno()) {
            die("Failed to connect to MySQL: ". mysqli_connect_error());
        }

        // 2. Begin Transaction (Essential for data consistency)
        mysqli_begin_transaction($con);

        try {
            // 3. Insert into approve_leave (Use Prepared Statement!)
            $insert_stmt = mysqli_prepare($con, "INSERT INTO `approve_leave` (`leave_id`,`name`,`department`,`leave_type`,`start_date`,`end_date`,`status`,`documents`) VALUES (?,?,?,?,?,?,?,?)");
            mysqli_stmt_bind_param($insert_stmt, "ssssssss", $leave_id, $name, $dept, $leaveType, $startDate, $endDate, $status, $file); // Bind the $file variable!
            mysqli_stmt_execute($insert_stmt);

            // 4. Delete from leaves (Use Prepared Statement!)
            $delete_stmt = mysqli_prepare($con, "DELETE FROM `leaves` WHERE `leave_id`=?");
            mysqli_stmt_bind_param($delete_stmt, "s", $leave_id);
            mysqli_stmt_execute($delete_stmt);

            // 5. Commit Transaction (If both operations succeed)
            mysqli_commit($con);

            // 6. File Upload (Only after successful database operations)
            move_uploaded_file($_FILES['documents']['tmp_name'], 'uploads/leaveDocuments/'.$file);

            $_SESSION['status'] = "Leave Request Approved Successfully!";
            header('Location: leave.php');
            exit(0);

        } catch (Exception $e) {
            // 7. Rollback Transaction on Error
            mysqli_rollback($con);

            $_SESSION['status'] = "<h4 class='alert alert-danger alert-dismissible fade'>Leave Request Approval Failed: ". $e->getMessage(). "</h4>"; // Display error message
            header('Location: leave.php');
            exit(0);
        } finally {
            // 8. Close Statements and Connection
            mysqli_stmt_close($insert_stmt);
            mysqli_stmt_close($delete_stmt);
            mysqli_close($con);
        }
    }
}


        if (isset($_POST['ApproveLeavee'])) {
            $leave_id = $_POST['leave_id']; // Get the ID of the row to approve
        
            // 1. Get the data from the source table
            $stmt_select = $con->prepare("SELECT leave_id, name,department, leave_type, start_date, end_date, status, documents FROM leaves WHERE `leave_id` = ?"); // Replace source_table and other_column
            $stmt_select->bind_param("i", $leave_id);
            $stmt_select->execute();
            $result = $stmt_select->get_result();
        
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $name = $row['name'];
                $dept = $row['department'];
                $leavetype = $row['leave_type'];
                $startdate = $row['start_date'];
                $enddate = $row['end_date'];
                $status = $row['status'];
                $documents = $row['documents'];
                // $other_column = $row['other_column']; // Get other columns as needed
        
                // 2. Insert the data into the destination table
                $stmt_insert = $con->prepare("INSERT INTO `approve_leave` (leave_id, name,department, leave_type, start_date, end_date, status, documents) VALUES (?, ?, ?)"); // Replace destination_table and other_column
                $stmt_insert->bind_param("ssss", $name,$dept, $leavetype, $startdate,$enddate,$status,$documents); // Adjust 'sss' if you have different data types
                $stmt_insert->execute();
        
                if ($stmt_insert->affected_rows > 0) {
                    // 3. (Optional) Delete the row from the source table (if needed)
                    $stmt_delete = $con->prepare("DELETE FROM leaves WHERE `leave_id` = ?");
                    $stmt_delete->bind_param("i", $leave_id);
                    $stmt_delete->execute();
        
                    if ($stmt_delete->affected_rows > 0 || !isset($stmt_delete)) { // Check if delete was successful or not needed
                        echo "Leave approved and moved successfully!";
                    } else {
                        echo "Error deleting from source table: " . $stmt_delete->error;
                    }
                    $stmt_delete->close(); // Close delete statement if used.
                } else {
                    echo "Error inserting into approve_leave table: " . $stmt_insert->error;
                }
        
                $stmt_insert->close();
            } else {
                echo "No row found with that ID.";
            }
        
            $stmt_select->close();
        }
        



    



    if(isset($_POST['']))
    {
        $staff_id = $_POST['approve_id'];
        // $name    = $_POST['name'];
        // $phone   = $_POST['phone'];
        // $email   = $_POST['email'];
        // $pass    = $_POST['password'];



        // $query = "UPDATE `users` SET name='$name', phone='$phone', email='$email', password='$pass' WHERE `id`='$user_id'";

        // $query  = "DELETE FROM users WHERE id='$userid'";


        //   -- Optional condition



// $query = "INSERT INTO `approved_leaves` WHERE `id`='$userid'";
//         $query_run = mysqli_query($con, $query);

        // $query = "INSERT INTO approved_leaves (`leave_id`,`id`,`name`,`leave_type`,`start_date`,`end_date`)
        // SELECT `request_id`,`id`, `name`, `leave_type` ,`start_date`,`end_date` FROM leave_requests WHERE `id`='$user_id'";
        

        $query ="INSERT INTO `approved_leaves` (`id`,`name`,`leave_type`,`start_date`,`end_date`)
        SELECT (`id`,`name`,`leave_type`,`start_date`,`end_date`)  FROM `leave_requests` `id`='$staff_id'";
        $query_run = mysqli_query($con, $query);

        if($query_run)
        {
            $_SESSION['status']  = "Leave Approved Successfully!";
            header('Location: leave.php');
        }
        else 
        {
            $_SESSION['status']  = "<h4 class='alert alert-danger alert-dismissible fade'>Leave Approve Failed!</h4>";
            header('Location: leave.php');
        }

    }


    if(isset($_POST['MoveUserbtn']))
    {
        $userid = $_POST['approve_id'];
        // $name    = $_POST['name'];
        // $phone   = $_POST['phone'];
        // $email   = $_POST['email'];
        // $pass    = $_POST['password'];



        // $query = "UPDATE `users` SET name='$name', phone='$phone', email='$email', password='$pass' WHERE `id`='$user_id'";

        // $query  = "DELETE FROM users WHERE id='$userid'";


        //   -- Optional condition



// $query = "INSERT INTO `approved_leaves` WHERE `id`='$userid'";
//         $query_run = mysqli_query($con, $query);

        // $query = "INSERT INTO approved_leaves (`leave_id`,`id`,`name`,`leave_type`,`start_date`,`end_date`)
        // SELECT `request_id`,`id`, `name`, `leave_type` ,`start_date`,`end_date` FROM leave_requests WHERE `id`='$user_id'";
        

//         $query ="INSERT INTO users1
// SELECT * FROM users WHERE `id`='$user_id'";


$query = "INSERT INTO users1 SELECT (`id`,`name`,`phone`,`email`,`password`,`role`,`created_at`) FROM users WHERE `id`='$user_id'";
$query_run = mysqli_query($con, $query);
// INSERT INTO archived_orders
// SELECT * FROM orders
// WHERE status = 'pending';

        if($query_run)
        {
            $_SESSION['status']  = "User Moved Successfully!";
            header('Location: registered.php');
        }
        else 
        {
            $_SESSION['status']  = "<h4 class='alert alert-danger alert-dismissible fade'>User Move Failed!</h4>";
            header('Location: registered.php');
        }

    }



if(isset($_POST['DeleteUserbtn']))
    {
        $userid = $_POST['delete_id'];
        
        $query  = "DELETE FROM users WHERE id='$userid'";
        $query_run = mysqli_query($con, $query);

        if($query_run)
        {
            $_SESSION['status']  = "User Deleted Successfully!";
            header('Location: registered.php');
        }
        else 
        {
            $_SESSION['status']  = "<h4 class='alert alert-danger alert-dismissible fade'>User Deleting Failed!</h4>";
            header('Location: registered.php');
        }

    }


    
    if (isset($_POST['DeleteStaffbtn'])) {
    $staff_id = $_POST['delete_id'];

    

    $query = "DELETE FROM staff WHERE id ='$staff_id'";
    $query_run = mysqli_query($con, $query);

    if ($query_run) {
        $_SESSION['status'] = "Staff Deleted Successfully!";
         header('Location: staff.php');
    } else {
          $_SESSION['status']  = "<h4 class='alert alert-danger alert-dismissible fade'>Failed Staff Deletion!</h4>";
            header('Location: staff.php');
    }

    
}



   


    if(isset($_POST['DeleteLeavebtn']))
    {
        $leaveid = $_POST['delete_id'];
        // $name    = $_POST['name'];
        // $phone   = $_POST['phone'];
        // $email   = $_POST['email'];
        // $pass    = $_POST['password'];



        // $query = "UPDATE `users` SET name='$name', phone='$phone', email='$email', password='$pass' WHERE `id`='$user_id'";

        $query  = "DELETE FROM `leaves` WHERE id='$leaveid'";
        $query_run = mysqli_query($con, $query);

        if($query_run)
        {
            $_SESSION['status']  = "Staff Leave Deleted Successfully!";
            header('Location: leave.php');
        }
        else 
        {
            $_SESSION['status']  = "<h4 class='alert alert-danger alert-dismissible fade'>Staff Leave Deleting Failed!</h4>";
            header('Location: leave.php');
        }

    }





    if(isset($_POST['addDepartment']))
    {
        $name                 =      $_POST['name'];
        $category             =      $_POST['category'];
        $director             =      $_POST['director'];
        $overview             =      $_POST['overview'];
        $no_staffs            =      $_POST['no_staffs'];
        

        $user_query = "INSERT INTO `departments` (name,category,director,overview,no_staffs) 
        VALUES ('$name','$category','$no_staffs','$overview','$no_staffs')";
        
        
        
                $user_query_run = mysqli_query($con, $user_query);
        
                if($user_query_run)
                {

                    $_SESSION['status']  = "Department Registered Successfully!";
                    header('Location: departments.php');
                }
                else 
                {
                    $_SESSION['status']  = "<h4 class='alert alert-danger alert-dismissible fade'>Department Registration Failed!</h4>";
                    header('Location: departments.php');
                }
            }
        
           

            if (isset($_POST['DeleteDepartment'])) {
    $dept_id = $_POST['delete_dept'];

    $stmt = $con->prepare("DELETE FROM departments WHERE id = ?");
    $stmt->bind_param("i", $dept_id);

    if ($stmt->execute()) {
        $_SESSION['status'] = "Department deleted successfully!";
    } else {
        $_SESSION['status'] = "Failed to delete department!";
    }

    $stmt->close();
    header('Location: departments.php');
    exit(0);
}

   


?>