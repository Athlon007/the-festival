<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <title>Update User</title>
</head>



  <body>
    <div class="container">
      <h1 class="text-center">Password Reset</h1>
      <p class="text-center">Please enter your new password below:</p>
      <form class="row g-3 needs-validation" method="post" action="updatePassword" novalidate>
        <div class="col-md-12">
          <label for="new-password" class="form-label">New Password:</label>
          <input type="password" class="form-control" id="new-password" name="newPassword" required>
          <div class="invalid-feedback">Please enter your new password.</div>
        </div>
        <div class="col-md-12">
          <label for="confirm-password" class="form-label">Confirm New Password:</label>
          <input type="password" class="form-control" id="confirm-password" name="confirmPassword" required>
          <div class="invalid-feedback">Please confirm your new password.</div>
        </div>
        <div class="col-md-12">
          <button type="submit" class="btn btn-primary" name="resetPasswordButton">Submit</button>
        </div>
      </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.min.js"></script>
  </body>
</html>