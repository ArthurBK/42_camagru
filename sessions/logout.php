<?PHP
session_start();
unset($_SESSION['loggued_on_user']);
header("Location: ../index.php");
?>
