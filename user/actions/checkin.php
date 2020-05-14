<?php
session_start();
//Include Database Connection
include("../../includes/con.php");
// Check First field is Filled
error_reporting(E_ALL);
ini_set('display_errors', '1');
$userid = $_SESSION["id"];


echo "RestaurantID: ".$_POST["merchantid"];
if (isset($_POST["temperature"])) {

    $temp = $_POST["temperature"];
    if (isset($_POST["merchantid"])) {
        $merchantid = $_POST["merchantid"];

        $sql = "INSERT INTO checkin ( merchantid, userid, datetime, temperature)
VALUES ( $merchantid, $userid, NOW() , $temp)";

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
