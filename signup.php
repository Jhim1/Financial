<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Financial Guardian - Sign Up</title>

  <?php include('./header.php'); ?>
  <?php include('./db_connect.php'); ?>
  <?php 
  session_start();
  if(isset($_SESSION['login_id']))
    header("location:index.php?page=home");
  ?>

</head>
<style>
  /* Your CSS styles for signup form */
</style>

<body>
  <main id="main" class="bg-white">
    <div id="login-left">
      <img src="fgs.png" >
    </div>

    <div id="login-right">
      <div class="card col-md-8">
        <div class="card-body">
          <form id="signup-form" action="signup_process.php" method="post">
            <div class="form-group">
              <label for="name" class="control-label">Full Name</label>
              <input type="text" id="name" name="name" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="email" class="control-label">Email</label>
              <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="dob" class="control-label">Date of Birth</label>
              <input type="date" id="dob" name="dob" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="password" class="control-label">Password</label>
              <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="income" class="control-label">Monthly Income</label>
              <input type="number" id="income" name="income" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="expenses" class="control-label">Monthly Expenses</label>
              <input type="number" id="expenses" name="expenses" class="form-control" required>
            </div>
            <!-- Add more finance-related fields as needed -->
            <center><button type="submit" class="btn-sm btn-block btn-wave col-md-4 btn-primary">Sign Up</button></center>
          </form>
        </div>
      </div>
    </div>
  </main>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>
</body>
</html>
  