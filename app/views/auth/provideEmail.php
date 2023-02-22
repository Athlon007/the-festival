<!DOCTYPE html>
<html>

<head>
    <title>Provide email</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- Font Awesome icons -->
    <script src="https://kit.fontawesome.com/af7ae585f1.js" crossorigin="anonymous"></script>
</head>


<body>
  <div class="container mt-5">
    <?php if (isset($successMessage)): ?>
    <div class="alert alert-success" role="alert">
      <?php echo $successMessage; ?>
    </div>
    <?php endif; ?>

    <?php if (isset($errorMessage)): ?>
    <div class="alert alert-danger" role="alert">
      <?php echo $errorMessage; ?>
    </div>
    <?php endif; ?>

    <h2 class="mb-4">Provide your email</h2>
    <form method="POST" action="sendEmail">
      <div class="form-group">
        <label for="emailField">Your email</label>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="far fa-envelope"></i></span>
          </div>
          <!-- <input id="emailField" type="email" class="form-control" placeholder="Email.." required> -->
          <input type="text" class="form-control" id="emailField" name="emailField" placeholder="Email.." autocomplete="off" required>

        </div>
      </div>
      <!-- <button id="sendEmail" type="button" class="btn btn-success" onclick="resetPassword()">Send Email</button> -->
      <button type="submit" name="submitEmail" class="btn btn-primary">Send Email</button>

    </form>
  </div>

  <script src="../js/resetpassword.js"></script>
</body>

</html>