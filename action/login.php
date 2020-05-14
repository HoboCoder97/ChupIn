<?php
include ("../includes/con.php");
if (isset($_POST["email"])){
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];

    $sql = "SELECT id, email, password, usertype FROM users WHERE email = ? ";


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
                mysqli_stmt_bind_result($stmt, $id, $email, $hashed_password, $usertype);
                if(mysqli_stmt_fetch($stmt)){

                    if(password_verify($pwd, $hashed_password)){
                        // Password is correct, so start a new session
                        session_start();

                        // Store data in session variables
                        $_SESSION["loggedin"] = true;
                        $_SESSION["usertype"] = $usertype;
                        $_SESSION["email"] = $email;
                        $_SESSION["id"] = $id;
                        if ($usertype==1){
                        echo ("<script LANGUAGE='JavaScript'>
    window.alert('Succesfully Logged In');
    window.location.href='../user/index.php';
    </script>");}
                        else if ($usertype==2){
                            echo ("<script LANGUAGE='JavaScript'>
    window.alert('Succesfully Logged In');
    window.location.href='../merchant/index.php';
    </script>");
                        }


                    } else{
                        // Display an error message if password is not valid
                        echo ("<script LANGUAGE='JavaScript'>
    window.alert('Wrong password');
    window.location.href='../index.php';
    </script>");
                    }
                }
            } else{
                // Display an error message if username doesn't exist
                echo ("<script LANGUAGE='JavaScript'>
    window.alert('Username does not exist');
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
