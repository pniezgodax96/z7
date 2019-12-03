<?php
require_once('dbconnect.php');   
        $idu=$_COOKIE['user'];
        if(IsSet($usr)){
      $zapytanie ="SELECT * FROM logi WHERE idu='$idu'";
      $rezultat = mysqli_query($polaczenie, $zapytanie); 
      $wiersz1 = mysqli_fetch_array($rezultat); 
      }
    ?>
<html>
<head>
  <title>Niezgoda</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
</head>

<body>
<?php
require_once('dbconnect.php');
$usr=$_COOKIE['user_n'];
if(IsSet($usr)){
    ?>
<?php
 echo "<p align=right>Zalogowany: <b>",$_COOKIE['user_n']," </b></p>";
 echo "<p align=right><br><a href='wyloguj.php'>Wyloguj</a></p>";
 ?>
<p><b><font color="red">
<?php
 if(IsSet($usr)){
      $zapytanie ="SELECT * FROM logi WHERE idu='$idu'";
      $rezultat = mysqli_query($polaczenie, $zapytanie); 
      $wiersz1 = mysqli_fetch_array($rezultat); 
      }
 if(!empty($wiersz1)){
    echo "<p align=right>Ostatnie błędne logowanie: ",$wiersz1['bledne_logowanie'],"</p><hr></hr>";
   
    }
?>
</font></b></p>
<b>Moja chmura:</b><br>
<?php

$dir= "/z7/users/$usr";
$files = scandir($dir);
$length = count($files);
for($x = 2; $x < $length; $x++) {
    
  if (is_file("/z7/users/$usr/$files[$x]")){
    echo "<a href='/z7/users/$usr/$files[$x]' download='$files[$x]'>$files[$x]</a><br>";
  }else{ 
      echo $files[$x],"<br>";
      $dir2= "/z7/users/$usr/$files[$x]";
      $files2 = scandir($dir2);
      $length2 = count($files2);
        for($y = 2; $y < $length2; $y++) {
        
        if (is_file("/z7/users/$usr/$files[$x]/$files2[$y]")){
        echo "-<a href='/z7/users/$usr/$files[$x]/$files2[$y]' download='$files2[$y]'>$files2[$y]</a>";
        }else{ 
            echo "-",$files2[$y];
        }
            echo "<br>";
            }
   }
  }
    echo "<br><hr></hr>";

?>
<br><br>
<b>Stwórz nowy folder:</b>
<form method="POST" action="stworz_katalog.php">
        Podaj nazwę katalogu:<input type="text" name="katalog">
        <input type="submit" value="Stwórz"/><hr></hr>
    </form>
<form action="odbierz.php" method="POST" ENCTYPE="multipart/form-data">
<b>Wybierz plik, a następnie prześlij do odpowiedniego folderu:</b> <input type="file" name="plik"/><br>
<?php
if (is_dir($dir)) {
    if ($d = opendir($dir)) {
        while (($file = readdir($d)) !== false) {
            if(is_dir("/z7/users/$usr/$file") && $file != '.' && $file != '..'){
            echo "<input type=\"radio\" name=\"folder\" value =$file>$file<br>";
            }
        }
        closedir($d);
    }
}
?>
 <input type="submit" value="Prześlij"/>
 
 <br>
 </form>
    <?php
}else{
echo "<b>Nie jesteś zalogowany!</b>";
sleep(4);
echo "<script>location.href='wyloguj.php';</script>";}
?>
</body>
</html>