<?php
session_start();
session_destroy();
echo("<script LANGUAGE='JavaScript'>
    window.alert('You are Logged Out');
    window.location.href='../../index.php';
    </script>");