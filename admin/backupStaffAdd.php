 
if (isset($_POST['addStaffs'])) {
    include('config/dbcon.php');

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

    // Validate required
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

    $document_filenames = implode(',', $uploaded_docs); // Save to DB

    // ===== INSERT INTO DB =====
  $query = "INSERT INTO staff (name, photo, department, position, gender, title, education, address, phone, date, skills, documents)
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($con, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssssssssssss", $name, $new_image_name, $department, $position,$gender, $title, $education, $address, $phone, $date, $skills, $document_filenames);
        $execute = mysqli_stmt_execute($stmt);

        if ($execute) {
            $_SESSION['status'] = "Staff added successfully!";

            $message = "New staff member <strong>$name</strong> has been added.";
            mysqli_query($con, "INSERT INTO notifications (type, message) VALUES ('staff', '$message')");

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
