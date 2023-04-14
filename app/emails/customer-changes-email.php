<!DOCTYPE html>
<!--Author: Joshua-->
<html>
    <head>
        <title>Changes to Account</title>
        <style type="text/css">
        /* Add some styles for the email body */
        body {
            font-family: Arial, sans-serif;
            font-size: 16px;
            line-height: 1.5;
            color: #333333;
            margin: 0;
            padding: 0;
        }
        h1 {
            font-size: 24px;
            font-weight: bold;
            color: #003399;
            margin: 0;
            padding: 0;
        }
        p {
            margin: 0 0 10px 0;
            padding: 0;
        }
    </style>
    </head>
    <body>
        <h2>
            Account changes
        </h2>
        <p>
            Dear customer,
        </p>
        <p>
            Changes have been made to your account. If you did not make these changes, contact us immediately by replying to this e-mail.
        </p>
        <p>
            Your account number: <?php echo $customer->getUserId(); ?>
        </p>
    </body>
</html>