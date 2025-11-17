 <!-- Navbar -->
 <nav class="main-header navbar navbar-expand navbar-primary navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
          <li class="nav-item">
              <div class="dropdown">
                  <button class="btn btn-light dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                    <?php 
                    
                      if(isset($_SESSION['auth']))
                      {
                        echo $_SESSION['auth_user']['user_name'];

                        
                      }
                      else 
                      {
                        echo "Not Logged In";
                      }
                    ?>
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <?php

                  // if (!isset($_SESSION['user'])) {
                  //   // Redirect to login page if not logged in
                  //   header("Location: login.php");
                  //   exit;
                  // }

                  // Get user information from session
                  $user = $_SESSION['auth_user'];

                  // Check if the user is an admin
                  $isAdmin = ($user['user_role'] === 'admin'); 

                  ?>
                    <?php if ($isAdmin): ?> 
                        <!-- <a href="change_password.php">Change Password</a>
                        <a href="manage_users.php">Manage Users</a> -->
                        <a class="dropdown-item" href="registered-edit.php">Change Password</a>
                      <a class="dropdown-item" href="registered.php">Manage Users</a>
                    <?php endif; ?> 
                      
                      
                    <form action="code.php" method="POST">
                    <button type="submit" name="logout_btn" class="dropdown-item">Logout</button>
                </form>
                
                  </div>
              </div>

           </li>
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

 <li class="nav-item dropdown">
  <a class="nav-link" data-toggle="dropdown" href="#" id="notificationDropdown">
    <i class="far fa-bell"></i>
    <span class="badge badge-warning navbar-badge" id="notification-count">0</span>
  </a>
  <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="notification-list" style="min-width: 300px;">
    <span class="dropdown-item dropdown-header">No Notifications</span>
  </div>
</li>


    
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- <script>
function fetchNotifications() {
  fetch('fetch-notifications.php')
    .then(res => res.json())
    .then(data => {
      document.getElementById('notification-count').textContent = data.count;

      const list = document.getElementById('notification-list');
      list.innerHTML = '<span class="dropdown-item dropdown-header">' + data.count + ' Notifications</span>';

      if (data.notifications.length === 0) {
        list.innerHTML += '<div class="dropdown-divider"></div><a href="#" class="dropdown-item text-muted">No new notifications</a>';
      }

      data.notifications.forEach(n => {
        list.innerHTML += `
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-bell mr-2"></i> ${n.message}
            <span class="float-right text-muted text-sm">${n.time}</span>
          </a>
        `;
      });

      list.innerHTML += '<div class="dropdown-divider"></div><a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>';
    });
}

setInterval(fetchNotifications, 10000); // every 10s
fetchNotifications();

// Optional: Mark as read when dropdown opens
document.getElementById('notificationDropdown').addEventListener('click', () => {
  fetch('mark-read.php').then(() => fetchNotifications());
});
</script> -->
