<?PHP
session_start();
include("auth.php");
$dir_name = "/Users/abonneca/http/MyWebSite/rush00";
if (admin($_SESSION['loggued_on_user']) !== true) {
  header("Location: index.php");
  return;
}
$str2 = file_get_contents("users.json");
$users = json_decode($str2, true);

      // print_r($_POST);
foreach ($users as $key => $value) {
  if ($value[id] == $_POST['id']) {
    {
      $users[$key][login] = $_POST['login'];
      $users[$key][passwd] = $_POST['passwd'];
      $users[$key][admin] = ($_POST['admin'] == "on" ? true : false);
      file_put_contents("users.json", json_encode($users));
      header ("Location: admin.php?page=users");
      return;
    }
  }
}
?>
