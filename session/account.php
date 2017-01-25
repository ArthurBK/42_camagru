<?php
session_start();
print("<link rel=\"stylesheet\" href=\"style.css\" type=\"text/css\">");
print("<div class=\"navbar\">");
print("<div><a href=\"panier.php\">Mon Panier</a></div>");
if ($_SESSION['loggued_on_user'] != "")
{
  print("<div><a href=\"account.php\">My Account</a></div>");
  print("<div><a href=\"logout.php\">Log Out</a></div>");
}
else
{
  header("Location: index.php");
  return ;
}
print("</div>");

$dir_name = "/Users/abonneca/http/MyWebSite/rush00";
$users = json_decode(file_get_contents($dir_name."/users.json"), true);
// print_r($users);
foreach ($users as $key => $user) {
  if ($user['login'] === $_SESSION['loggued_on_user'])
      $current_user = $user;
  }

?>



<form action="update_account.php" method="post">
  Identifiant: <input type="text" name="login" value=<?php echo htmlspecialchars($current_user[login]); ?> />
  <br />
  Old PWD: <input type="password" name="oldpw" />
  <br />
  New PWD: <input type="password" name="newpw" />
  <br />
  <input type="hidden" name="id" value=<?php echo htmlspecialchars($current_user[id]); ?> />
  <input type="submit" name="submit" value="update"/></form>
<a href="destroy.php">Delete My Account</a>
