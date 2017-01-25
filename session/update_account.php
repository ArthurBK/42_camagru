<?PHP
$dir_name = "/Users/abonneca/http/MyWebSite/rush00";
if (empty($_POST['oldpw']) || empty($_POST['newpw']) || empty($_POST['login']))
  header("Location: account.php");
else
{
  if (file_exists($dir_name."/users.json"))
  {
  $my_array = json_decode(file_get_contents($dir_name."/users.json"), true);
  foreach ($my_array as $key => $value) {
    if ($value[id] == $_POST['id'] && $value[passwd] == $_POST['oldpw'])
    {
        $my_array[$key][passwd] = $_POST['newpw'];
        $my_array[$key][login] = $_POST['login'];
        file_put_contents($dir_name."/users.json", json_encode($my_array));
        header("Location: index.php");
        return;
    }
    }

  }
  header("Location: account.php");
}
?>
