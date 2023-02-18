<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <?php if (isset($successMessage)): ?>
        <div style="color: green;"><?php echo $successMessage; ?></div>
    <?php endif; ?>

    <?php if (isset($errorMessage)): ?>
        <div style="color: red;"><?php echo $errorMessage; ?></div>
    <?php endif; ?>

    <h2>Reset Password</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" name="email" value="<?php echo $email; ?>">
        <input type="hidden" name="reset_token" value="<?php echo $reset_token; ?>">
        <label for="password">New Password:</label>
        <input type="password" name="password" id="password" required>
        <br>
        <label for="passwordConfirm">Confirm New Password:</label>
        <input type="password" name="passwordConfirm" id="passwordConfirm" required>
        <br>
        <input type="submit" name="submitPassword" value="Reset Password">
    </form>
</body>
</html>
