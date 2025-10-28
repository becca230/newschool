<?php
// forgot_password.php
include('include/db_connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password | School Management</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="css/styles.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-light">

<?php
include('include/navbar.php');
?>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="card shadow-lg border-0 rounded-3">
        <div class="card-body p-4">
          <h4 class="text-center mb-3">🔑 Forgot Password</h4>

          <!-- Username form -->
          <form id="usernameForm">
            <div class="mb-3">
              <label class="form-label fw-semibold">Enter Username</label>
              <input type="text" name="username" required class="form-control" placeholder="Enter your username">
            </div>
            <button type="submit" class="btn btn-primary w-100">Continue</button>
          </form>

          <div id="security_question" class="mt-4"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
$(function(){
  $("#usernameForm").on("submit", function(e){
    e.preventDefault();
    $.ajax({
      url: "reset_password.php",
      type: "POST",
      data: $(this).serialize(),
      success: function(response){
        $("#security_question").html(response);
      },
      error: function(xhr, status, error){
        alert("⚠ Error: " + error);
      }
    });
  });
});
</script>

<?php include('include/footer.php'); ?>
</body>
</html>
