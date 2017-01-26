<?php
include ("navbar.php");
 ?>
 <br>
 <div style="text-align: center;">
<form action="create_user.php" method="post">
  Email: <input type="email" name="email" required/>
  <br />
  Username: <input type="text" name="username" required/>
  <br />
  Mot de passe: <input type="password" name="password" required/>
  <br />
  <input type="submit" name="submit" value="OK"/></form>
</div>