<?PHP
session_start();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Selfie Generator</title>
<link rel="stylesheet" type="text/css" href="stylesheet.css">

</head>
<body>

<div class="navbar">
  <ul>
    <li> <a href="scene.php"> <strong> Selfie Generator </strong> </a></li>
    <li> <a href="index.php"> <strong> Gallery </strong> </a></li>
<!-- Navbar -->

<?php
print("<link rel=\"stylesheet\" href=\"style.css\" type=\"text/css\">");
print("<script src=\"//code.jquery.com/jquery-1.11.0.min.js\"></script>");
print("<div class=\"navbar\">");

if ($_SESSION['loggued_on_user'] != "") {
    print("<li style='float:right' ><a href=\"account.php\">My Account</a></li>");
    print("<li style='float:right' ><a href=\"sessions/logout.php\">Log Out</a></li>");
} else {
    print("<li><a href=\"sessions/new_user.php\">Sign up</a></li><li><a href=\"sessions/login_form.php\">Login</a></li>");
}
print("</div>");?>
  </ul>
</div>
