<?php
include("navbar.php");
?>
<br>
<div style="text-align: center;">
<form action="login.php" method="post">
  Username: <input type="text" name="username" required/>
  <br />
  Mot de passe: <input type="password" name="password" required/>
  <br />
  <input type="submit" name="submit" value="OK"/></form>
<a href="index.php">Back</a>
</div>