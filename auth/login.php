<?php
session_start();
include 'db.php';
include 'config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   $email = $_POST['email'];
   $password = md5($_POST['password'] . PASS_SALT);
   $result = $mysqli->query("SELECT * FROM users WHERE user_email = '$email' AND user_password = '$password'");
   if ($result && $result->num_rows > 0) {
       $user = $result->fetch_assoc();

       $_SESSION['user']['id'] = $user['id'];
       $_SESSION['user']['name'] = $user['user_name'];
       $_SESSION['user']['last_login'] = $user['user_last_login'];

       $last_login = date('Y-m-d H:i:s');
       $user_session_id = $_COOKIE['auth'] ?? session_id();
       $user_id = $user['id'];
       $mysqli->query("UPDATE users SET user_last_login='$last_login', user_session_id='$user_session_id' WHERE id=$user_id");
       session_regenerate_id(true);
       header("Location: index.php");
   } else {
       $_SESSION['alert']['error'] = "Login albo hasło jest nieprawidłowe.";
       header("Location: index.php");
   }
} else {

   echo '<form method="POST">
           Email: <input type="email" name="email" required><br>
           Password: <input type="password" name="password" required><br>
<input type="submit" value="Login">
</form>';
}
?>
