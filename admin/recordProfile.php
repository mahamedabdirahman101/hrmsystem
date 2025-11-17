<?php
include('authentication.php');
include('assets/includes/header.php');
include('assets/includes/sideForAdmin.php');
include('assets/includes/topbar.php');
include('config/dbcon.php');
?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Disciplinary Record Profile</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Record Profile</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3">
          <div class="card card-primary card-outline">
            <?php
            if (isset($_GET['id'])) {
              $record_id = intval($_GET['id']);

              $query = "SELECT dr.*, s.name AS staff_name, s.department, s.photo 
                        FROM discipline_records dr 
                        JOIN staff s ON dr.staff_id = s.id 
                        WHERE dr.id = ? 
                        LIMIT 1";

              $stmt = $con->prepare($query);
              if ($stmt) {
                $stmt->bind_param("i", $record_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                  $record = $result->fetch_assoc();
            ?>
                  <div class="card-body box-profile text-center">
                    <img class="profile-user-img img-fluid img-circle" 
                         src="uploads/staff_photos/<?= htmlspecialchars($record['photo']) ?>" 
                         alt="Staff Photo">
                    <h3 class="profile-username"><?= htmlspecialchars($record['staff_name']) ?></h3>
                    <p class="text-muted"><?= htmlspecialchars($record['department']) ?></p>
                  </div>
            <?php
                } else {
                  echo "<div class='p-3 text-danger'>No record found for this staff.</div>";
                }
              } else {
                echo "<div class='p-3 text-danger'>Failed to prepare statement: " . $con->error . "</div>";
              }
            } else {
              echo "<div class='p-3 text-danger'>Invalid access. No record ID given.</div>";
            }
            ?>
          </div>
        </div>

        <div class="col-md-9">
          <div class="card">
            <div class="card-header">
              <a href="discipline_records.php" class="btn btn-danger btn-sm float-right">Back</a>
              <h3 class="card-title">Record Details</h3>
            </div>
            <div class="card-body">
              <?php if (!empty($record)): ?>
                <strong>Offense Type</strong>
                <p class="text-muted"><?= htmlspecialchars($record['offense_type']) ?></p>
                <hr>

                <strong>Description</strong>
                <p class="text-muted"><?= nl2br(htmlspecialchars($record['description'])) ?></p>
                <hr>

                <strong>Date Reported</strong>
                <p class="text-muted"><?= htmlspecialchars($record['date_reported']) ?></p>
                <hr>

                <strong>Action Taken</strong>
                <p class="text-muted"><?= htmlspecialchars($record['action_taken']) ?></p>
                <hr>

                <strong>Status</strong>
                <p class="text-muted">
                  <span class="badge badge-<?= $record['status'] == 'Resolved' ? 'success' : 'warning' ?>">
                    <?= htmlspecialchars($record['status']) ?>
                  </span>
                </p>
              <?php endif; ?>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>
</div>

<?php include('assets/includes/footer.php'); ?>
<?php include('assets/includes/script.php'); ?>
