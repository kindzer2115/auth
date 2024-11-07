<?php
session_start();
include 'db.php';
include 'config.php';
if (isset($_SESSION['user'])) {

   echo "<h1>Witaj, {$_SESSION['user']['name']} – ostatnio logowałeś się: {$_SESSION['user']['last_login']}</h1>";
   echo '<form method="POST">
<input type="submit" value="Wylogin">
</form>';
} else {

   if (isset($_SESSION['alert']['error'])) {
       echo "<p>{$_SESSION['alert']['error']}</p>";
       unset($_SESSION['alert']);
   }
   echo '<a href="register.php">Rejestracja</a> | <a href="login.php">Logowanie</a>';
}

unset($_SESSION['alert']);
session_destroy();
?>
