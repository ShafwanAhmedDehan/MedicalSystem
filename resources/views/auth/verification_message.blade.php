<!DOCTYPE html>
<html>

<head>
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
    <style>
        body {
            text-align: center;
            padding: 40px 0;
            background: #EBF0F5;
        }

        h1 {
            font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
            font-weight: 900;
            font-size: 40px;
            margin-bottom: 10px;

        }

        p {
            font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
            font-size: 20px;
            margin: 0;
        }

        i {
            font-size: 100px;
            line-height: 200px;
            margin-left: -15px;
        }

        .card {
            background: white;
            padding: 60px;
            border-radius: 4px;
            box-shadow: 0 2px 3px #C8D0D8;
            display: inline-block;
            margin: 0 auto;
        }

        .success {
            color: #88B04B;
        }

        .error {
            color: #FF6B6B;
        }
    </style>
</head>

<body>
    <div class="card">
        <h2 class="card-title">MedicalService</h2>
        <div style="border-radius: 200px; height: 200px; width: 200px; background: #F8FAF5; margin: 0 auto;">
            <?php
            //$message = "success"; // Change 'success', 'already_verified', or 'error' as needed
            if ($message == 'success' || $message == 'already_verified') {
                echo '<i class="checkmark">✓</i>';
            } elseif ($message == 'error') {
                echo '<i class="error-mark">❌</i>';
            }
            ?>
        </div>
        <!-- Conditionally display the message based on the 'message' variable -->
        <?php
        //$message = "success"; // Change 'success', 'already_verified', or 'error' as needed
        if ($message == 'success') {
            echo '<h1 class="success">Success</h1>';
            echo '<p>Email verified successfully;<br/> You can now login!</p>';
        } elseif ($message == 'already_verified') {
            echo '<h1 class="success">Success</h1>';
            echo '<p>Email is already verified;<br/> You can now login!</p>';
        } elseif ($message == 'error') {
            echo '<h1 class="error">Error</h1>';
            echo '<p>Sorry, Something went wrong.<br/> Please try again later!</p>';
        }
        ?>
        <!-- Add "Thanks, MedicalService" at the end in two lines -->
        <br>
        <br>
        <br>
        <div style="text-align: center;">
            <p>Thanks,</p>
            <p>MedicalService</p>
        </div>
    </div>
</body>

</html>
