<?PHP
session_start();
$str2 = file_get_contents("users.json");
$users = json_decode($str2, true);
include("auth.php");
if (admin($_SESSION['loggued_on_user']) !== true) {
  header("Location: index.php");
  return;
}
foreach ($users as $key => $value) {
// print((boolean)$value[admin]);
  if ($value[id] == $_GET['id'] + 1) {
    if ($_GET['action'] === "del")
    {
      unset($users[$key]);
      file_put_contents("users.json", json_encode($users));
      header ("Location: admin.php?page=users");
      return;
    }
    else
      $value_entry = $value;

  }
// print_r((int)$value_entry[admin]);
}
?>

<form action="update_user.php" method="post">
  Identifiant: <input type="text" name="login" value=<?php echo htmlspecialchars($value_entry[login]); ?> required/>
  <br />
  Mot de passe: <input type="password" name="passwd" value=<?php echo htmlspecialchars($value_entry[passwd]); ?> required/>
  <br />
  Admin?: <input type="checkbox" name="admin" <?php echo ((int)$value_entry[admin] == 0 ? "" : "checked"); ?>>
  <input type="hidden" name="id" value=<?php echo htmlspecialchars($value_entry[id]); ?> >
<br />
  <input type="submit" name="submit" value="Update"/></form>
