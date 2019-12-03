<?php
require_once('dbconnect.php');
$ip = $_SERVER["REMOTE_ADDR"];
$godzina = date("Y-m-d H:i:s", time());
$user=strtolower($_POST['user']);
$pass=$_POST['pass'];

 $zapytanie ="SELECT * FROM users WHERE login='$user'";
 $rezultat = mysqli_query($polaczenie, $zapytanie);
 $wiersz = mysqli_fetch_array($rezultat);
 $idu=$wiersz['id'];
 $zapytanie ="SELECT * FROM logi WHERE idu='$idu'";
 $rezultat = mysqli_query($polaczenie, $zapytanie); 
 $wiersz1 = mysqli_fetch_array($rezultat); 
 if(!$wiersz) //Jeśli brak, to nie ma użytkownika o podanym loginie
{
    echo "<b>Nie ma takiego użytkownika!</b>";
    sleep(2);
    echo "<script>location.href='wyloguj.php';</script>";
 }
else
 { // Jeśli wiersz istnieje
 if($wiersz['haslo']==$pass )// czy hasło zgadza się z bazą danych
 {  
     $spr=substr($wiersz1['proba'], 0, 2);
     $proba=$wiersz1['proba'];
     if($spr=="b-"){
            $czas_blokady = substr($proba, 2);
            if(time() < $czas_blokady){
            echo "<b><font color=\"red\">Wpisałeś 3 razy nie poprawnie hasło!<br>Ponowne logowanie: ",date("Y-m-d H:i:s ", $czas_blokady),"</font></b>"; 
            sleep(5);
            echo "<script>location.href='wyloguj.php';</script>";
            }else{
 if ((!isset($_COOKIE['user'])) || ($_COOKIE['user']!=$wiersz['id'])){
            setcookie("user", $wiersz['id'], mktime(23,59,59,date("m"),date("d"),date("Y")));
            setcookie("user_n", $wiersz['login'], mktime(23,59,59,date("m"),date("d"),date("Y")));
    }
          $zapytaniesql="INSERT INTO logi(idu, ip, pomyslne_logowanie) VALUES ('$idu','$ip','$godzina')";
          mysqli_query($polaczenie, $zapytaniesql);
          $zapytaniesql="UPDATE logi SET proba='0' WHERE idu='$idu'";
          mysqli_query($polaczenie, $zapytaniesql);
          header("Location: chmura.php");
 }}else{
      if ((!isset($_COOKIE['user'])) || ($_COOKIE['user']!=$wiersz['id'])){
            setcookie("user", $wiersz['id'], mktime(23,59,59,date("m"),date("d"),date("Y")));
            setcookie("user_n", $wiersz['login'], mktime(23,59,59,date("m"),date("d"),date("Y")));
    }
          $zapytaniesql="INSERT INTO logi(idu, ip, pomyslne_logowanie) VALUES ('$idu','$ip','$godzina')";
          mysqli_query($polaczenie, $zapytaniesql);
          $zapytaniesql="UPDATE logi SET proba='0' WHERE idu='$idu'";
          mysqli_query($polaczenie, $zapytaniesql);
          header("Location: chmura.php");
 }}
 else
 {
      $proba=$wiersz1['proba'];
     if ($proba=='2'){
              $proba="b-" . strtotime("+1 minutes", time());
              $zapytaniesql="UPDATE logi SET proba='$proba',bledne_logowanie='$godzina' WHERE idu='$idu'";
              mysqli_query($polaczenie, $zapytaniesql);
          }
          if(substr($proba, 0, 2) == "b-"){
            $czas_blokady = substr($proba, 2);
            if(time() < $czas_blokady){
            echo "<b><font color=\"red\">Wpisałeś 3 razy nie poprawnie hasło!<br>Ponowne logowanie: ",date("Y-m-d H:i:s ", $czas_blokady),"</font></b>"; 
            }else{
                $zapytaniesql="UPDATE logi SET proba='1',bledne_logowanie='$godzina' WHERE idu='$idu'";
                mysqli_query($polaczenie, $zapytaniesql);
                echo "<b>Niepoprawne hasło!</b>";

            }}else{  
            if (IsSet($wiersz1)){
                $proba=$wiersz1['proba']+1;
                $zapytaniesql="UPDATE logi SET proba='$proba',bledne_logowanie='$godzina' WHERE idu='$idu'";
                mysqli_query($polaczenie, $zapytaniesql);
                echo "<b>Niepoprawne hasło!</b>";

            }else{
         $proba=$wiersz1['proba']+1;
          $zapytaniesql="INSERT INTO logi(idu,ip,bledne_logowanie,proba) VALUES ('$idu','$ip','$godzina','$proba')";
          mysqli_query($polaczenie, $zapytaniesql);
          echo "<b>Niepoprawne hasło!</b>";

            }
            }
 mysqli_close($polaczenie);
 echo "<a href=\"wyloguj.php\"><input type=\"submit\" value=\"Powrót\"></a>";
 }
}
?>
