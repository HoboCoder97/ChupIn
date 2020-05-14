<?php
// Create Variables
$error = 0;
$msg = "";
//Include Database Connection
include ("../includes/con.php");
// Check First field is Filled
error_reporting(E_ALL);
ini_set('display_errors', '1');

if (isset($_POST["fullname"])){
    $restaurantname = $_POST["restaurantname"];
    $name = $_POST["fullname"];
    $contact = $_POST["contact"];
    $usertype = $_POST["usertype"];
    $password = $_POST["password"];
    $opt = $_POST["optin"];
    $email = $_POST["email"];
}
else {
    $error++;
    $msg .= "Full name not filled";

}

if ($error == 0){
    //Register User
    include("../includes/con.php");
    $password = trim(password_hash($_POST["password"], PASSWORD_DEFAULT));
    $sql = "INSERT INTO users (email, password, fullname , contact, usertype, optin, restaurantname)
VALUES ('$email', '$password', '$name', $contact, $usertype, $opt, $restaurantname)";

    if ($con->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {

        echo "Error: " . $sql . "<br>" . $con->error;
        die();
    }

    $con->close();
    //Notify
    echo ("<script LANGUAGE='JavaScript'>
    window.alert('Succesfully Updated');
    window.location.href='../index.php';
    </script>");
}
else {
    //Notify of Errors

    echo $msg;
    $msg = 'There is a problem with your registration: \n' . $msg;
    echo "<script type=text/javascript>var message = '" . $msg . "' ;" . "alert(message);window.location.href='../index.php'</script>";


}