<?php
session_start();
include('assets/includes/header.php');
?>

<style>
    body {
        background: linear-gradient(135deg, #007bff, #00c6ff);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .forgot-wrapper {
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
        max-width: 100px;
    }
</style>

<div class="forgot-wrapper">
    <img src="assets/dist/img/logo.jpg" class="logo-img" alt="Logo">

    <h5 class="text-center mb-3">Forgot Password</h5>
    <p class="text-muted text-center">Enter your registered email address to receive a reset link.</p>

    <form action="send-reset-link.php" method="POST">
        
        <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" class="form-control" placeholder="example@domain.com" required>
        </div>

        <button type="submit" name="reset_btn" class="btn btn-primary btn-block">Send Reset Link</button>

        <div class="text-center mt-2">
            <a href="login.php">Back to Login</a>
        </div>
    </form>
</div>

<?php include('assets/includes/script.php'); ?>
