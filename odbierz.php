<?php
$user=$_COOKIE['user_n'];
$folder=$_POST['folder'];
if (is_uploaded_file($_FILES['plik']['tmp_name']))
{
    if(IsSet($folder)){
        move_uploaded_file($_FILES['plik']['tmp_name'],$_SERVER['DOCUMENT_ROOT']."z7/users/$user/$folder/".$_FILES['plik']['name']);
    }else{
     move_uploaded_file($_FILES['plik']['tmp_name'],$_SERVER['DOCUMENT_ROOT']."z7/users/$user/".$_FILES['plik']['name']);
    }
}
header("Location: chmura.php");
?>