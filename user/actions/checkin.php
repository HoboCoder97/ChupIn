<?php
session_start();
//Include Database Connection
include("../../includes/con.php");
// Check First field is Filled
error_reporting(E_ALL);
ini_set('display_errors', '1');
$userid = $_SESSION["id"];
$code = $_POST["rescode"];


if (isset($_POST["temperature"])) {

    $temp = $_POST["temperature"];
    if (isset($_POST["rescode"])) {
        $resC = $_POST["rescode"];

        $query = "SELECT id FROM users WHERE code = $resC";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($result);
        $code2 = $row["id"];
        
        if (mysqli_num_rows($result)==1){


        $sql = "INSERT INTO checkin ( merchantid, userid, datetime, temperature)
VALUES ( $code2, $userid, NOW() , $temp)";

        if ($con->query($sql) === TRUE) {
            echo("<script LANGUAGE='JavaScript'>
    window.alert('Successful Check In ');
    window.location.href='../index.php';
    </script>");
        } else {

            echo "Error: " . $sql . "<br>" . $con->error;
            die();
        }
        }
        else {
               echo("<script LANGUAGE='JavaScript'>
    window.alert('Invalid Code');
    window.location.href='../index.php';
    </script>");
        }
    }
    else {
        echo("<script LANGUAGE='JavaScript'>
    window.alert('Please select Restaurant');
    window.location.href='../index.php';
    </script>");
    }
} else {
    echo("<script LANGUAGE='JavaScript'>
    window.alert('Please enter your Temperature');
    window.location.href='../index.php';
    </script>");
}




    $con->close();
