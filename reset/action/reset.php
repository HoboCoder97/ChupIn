<?php
include ("../../includes/con.php");
if (isset($_POST["email"])){
    $email = $_POST["email"];

    $sql = "SELECT id FROM users WHERE email = ? ";


    if($stmt = mysqli_prepare($con, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_username);

        // Set parameters
        $param_username = $email;

        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Store result
            mysqli_stmt_store_result($stmt);

            // Check if username exists, if yes then verify password
            if(mysqli_stmt_num_rows($stmt) == 1){
                // Bind result variables
                mysqli_stmt_bind_result($stmt, $id);
                if(mysqli_stmt_fetch($stmt)){
                    $key = trim(password_hash("$email".rand(1000,9000), PASSWORD_DEFAULT));
                    $query2  =  "INSERT INTO fpwd (email, resetkey, datetime) VALUES ('$email', '$key' , NOW())";
                    $result = mysqli_query ($con, $query2) or die(mysqli_error($con));
                    if ($result){
                        //Email User

                        require('phpmailer/class.phpmailer.php');
                        $mail = new PHPMailer();
                        $mail->IsSMTP();
                        $mail->SMTPDebug = 0;
                        $mail->SMTPAuth = TRUE;
                        $mail->SMTPSecure = "tls";
                        $mail->Port = 587;
                        $mail->Username = "your gmail username";
                        $mail->Password = "your gmail password";
                        $mail->Host = "smtp.gmail.com";
                        $mail->Mailer = "smtp";
                        $mail->SetFrom("Your from email", "from name");
                        $mail->AddReplyTo("from email", "PHPPot");
                        $mail->AddAddress("recipient email");
                        $mail->Subject = "Test email using PHP mailer";
                        $mail->WordWrap = 80;
                        $content = "<b>This is a test email using PHP mailer class.</b>";
                        $mail->MsgHTML($content);
                        $mail->IsHTML(true);
                        if (!$mail->Send())
                            echo "Problem sending email.";
                        else
                            echo "email sent.";

                        // Notify User
                        echo ("<script LANGUAGE='JavaScript'>
    window.alert('Please Check Your Email');
    window.location.href='../index.php';
    </script>");
                    }
                    else {
                        echo ("<script LANGUAGE='JavaScript'>
    window.alert('Something went wrong, please contact support@chupnow.com');
    window.location.href='../index.php';
    </script>");
                    }
                }
            } else{
                // Display an error message if username doesn't exist
                echo ("<script LANGUAGE='JavaScript'>
    window.alert('Email does not exist');
    window.location.href='../index.php';
    </script>");
            }
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }
}
else {
    echo ("<script LANGUAGE='JavaScript'>
    window.alert('Illegal access Detected.');
    window.location.href='../index.php';
    </script>");
}
// Close connection
mysqli_close($con);
