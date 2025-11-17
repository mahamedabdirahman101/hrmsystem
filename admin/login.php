<?php
session_start();
include('assets/includes/header.php');

if (isset($_SESSION['auth'])) {
    $_SESSION['status'] = "You are already logged in!";
    header('Location: index.php');
    exit(0);
}
?>

<style>
    body {
        background: linear-gradient(135deg, #007bff, #00c6ff);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .login-wrapper {
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        max-width: 400px;
        width: 100%;
    }

    .logo-img {
        display: block;
        margin: 0 auto 20px;
        max-width: 120px;
        height: auto;
    }

    .card-header h5 {
        margin-bottom: 0;
    }
</style>
<div class="card">
    <div class="card-header"><h3 class="card-title">Employee Management System</h3></div>
    
    <div class="card-body login-card-body">
        <img src="assets/dist/img/logo.jpg" alt="Company Logo" class="logo-img">

      <p class="login-box-msg">Sign in </p>

      <form action="logincode.php" method="post">
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" name="login_btn" class="btn btn-primary btn-block">Login</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      

      
      <!-- /.social-auth-links -->

      <p class="mb-1">
        <a href="forgot-password.php">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="register.php" class="text-center">Register a new membership</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>

<?php include('assets/includes/script.php'); ?>

