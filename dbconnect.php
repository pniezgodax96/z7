<?php
    //dane bazy danych
	$dbhost="serwer1961337.home.pl";
	$dbuser="31554600_lab7";
	$dbpassword="Haslodolab7.";
	$dbname="31554600_lab7";
    
    //sprawdzanie połączenia
    $polaczenie = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
    if (!$polaczenie) {
        echo "Błąd połączenia z MySQL." . PHP_EOL;
        echo "Errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }
?>