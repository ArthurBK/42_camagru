<?php
include "header.php";
include("navbar.php");
if (isset($_SESSION['loggued_on_user']) && $_SESSION['loggued_on_user'] !== "") {
    header("Location: index.php");
    return;
}
?>
<br>
<div style="text-align: center;">
<form action="send_passwd_link.php" method="post">
  Email: <input type="email" name="email" required/>
  <br />
  <input type="submit" name="submit" value="Send Password Link"/></form>
</div>
