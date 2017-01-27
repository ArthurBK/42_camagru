<?php
include("navbar.php");
?>
<br>
<div style="text-align: center;">
<form action="send_passwd_link.php" method="post">
  Email: <input type="email" name="email" required/>
  <br />
  <input type="submit" name="submit" value="Send Password Link"/></form>
</div>
