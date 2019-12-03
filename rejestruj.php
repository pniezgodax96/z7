<html>
<head>
  <title>Niezgoda</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
</head>
<body>
<form method="POST">
<b>Zarejestruj się:</b><br><br>
Login:<input type="text" name="nick"><br>
Hasło:<input type="password" name="haslo"><br>
Powtórz hasło:<input type="password" name="haslo2"><br><br>
<input type="submit" value="Wyślij"/></br>
<a href="index.php">Masz już konto? Zaloguj się!</a></p>
</form>

<?php
require_once('dbconnect.php');
    
if (IsSet($_POST['nick'])) {
    if($_POST['haslo'] == $_POST['haslo2']){ //sprawdzenie czy hasła są identyczne
    $login=$_POST['nick'];
    $password=$_POST['haslo'];
    $zapytaniesql="INSERT INTO users(login, haslo) VALUES ('$login', '$password')"; // wstawienie do bazy
    mysqli_query($polaczenie, $zapytaniesql);
    mysqli_close($polaczenie);
    mkdir ("users/$login", 0777); //uwtorzenie katalogu z nazwą loginu użytkownika

    echo "<b>Utworzono nowe konto!</b>";
    sleep(2);
    echo "<script>location.href='index.php';</script>";
    }else {
             echo "<b>Hasła nie są identyczne!</b>";
        }
}
?>
</body>
</html>
</html>




