<?php
session_start();
include 'db.php';
include 'config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   $name = $_POST['name'];
   $email = $_POST['email'];
   $password = md5($_POST['password'] . PASS_SALT);

   $stmt = $mysqli->prepare("SELECT id FROM users WHERE user_email = ?");
   $stmt->bind_param("s", $email);
   $stmt->execute();
   $stmt->store_result();
   if ($stmt->num_rows > 0) {

       $_SESSION['alert']['error'] = "Ten emajl został już użyty, użyj innego!";
       header("Location: register.php");
       exit();
   }
   $stmt->close();

   $stmt = $mysqli->prepare("INSERT INTO users (user_name, user_email, user_password) VALUES (?, ?, ?)");
   $stmt->bind_param("sss", $name, $email, $password);
   if ($stmt->execute()) {
       header("Location: index.php");
   } else {
       $_SESSION['alert']['error'] = "Rejestracja sie nieudała, Spróbuj ponownie!";
       header("Location: register.php");
   }
   $stmt->close();
} else {

    if (isset($_SESSION['alert']['error'])) {
        echo "<p>{$_SESSION['alert']['error']}</p>";
        unset($_SESSION['alert']['error']); 
     }
   
   echo '<form method="POST">
           Name: <input type="text" name="name" required><br>
           Email: <input type="email" name="email" required><br>
           Password: <input type="password" name="password" required><br>
<input type="submit" value="Register">
</form>';
}
?>
