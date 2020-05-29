<?php
include("../../includes/con.php");

$sql = "SELECT restaurantname FROM users WHERE code = ?";
$code =(int) $_GET['q'];

$stmt = $con->prepare($sql);
$stmt->bind_param("i", $code);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($name);
$stmt->fetch();
$stmt->close();

if ($name == ""){
    echo "Restaurant Not Found";
}
else {
    echo $name;
}
?>