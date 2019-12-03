<?php
header("Location: chmura.php");
$nazwa=$_POST['katalog'];
$user=$_COOKIE['user_n'];
mkdir ("users/$user/$nazwa", 0777);
?>