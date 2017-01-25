<?PHP
session_start();
if (empty($_POST['passwd']) || empty($_POST['login']) || $_POST['submit'] !== "OK")
  header("Location: form.php");
else
{
  $dir_name = "/Users/abonneca/http/MyWebSite/rush00";
  if (!file_exists($dir_name))
  		mkdir($dir_name);
  if (file_exists($dir_name."/users.json"))
  {
  $my_array = json_decode(file_get_contents($dir_name."/users.json"), true);
  // print($my_array);
  foreach ($my_array as $key => $value) {
    if ($value['login'] === $_POST['login'])
    {
          header("Location: new_account.php");
        return;
    }
    }

  }
  $new = array(
  "id" => $key + 2,
  "login" => $_POST['login'],
  "passwd" => $_POST['passwd'],
  "admin" => false
);
  $my_array[] = $new;
  file_put_contents($dir_name."/users.json", json_encode($my_array));
  $_SESSION['loggued_on_user'] = $_POST['login'];
  header("Location: index.php");
  // echo "OK\n";
}
?>
