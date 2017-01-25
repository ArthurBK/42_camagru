<?PHP
session_start();
// include("auth.php");
if (empty($_POST['password']) || empty($_POST['login']) || $_POST['submit'] !== "OK")
  header("Location: users/new_user.php");
else
{


  // foreach ($my_array as $key => $value) {
  //   if ($value['login'] === $_POST['login'])
  //   {
  //         header("Location: new_user.php");
  //       return;
  //   }

  $query = 'INSERT INTO users FROM foo WHERE id=:id AND cat=:categorie LIMIT :limit;';
  $prep = $pdo->prepare($query);

  $prep->bindValue(':limit', 10, PDO::PARAM_INT);
  $prep->bindValue(':id', 120, PDO::PARAM_INT);
  $prep->bindValue(':categorie', 'bar', PDO::PARAM_STR);
  $prep->execute();

  $arrAll = $prep->fetchAll();

  $prep->closeCursor();
  $prep = NULL;

  "login" => $_POST['login'],
  "passwd" => $_POST['passwd'],


  header("Location: scene.php");
  return ;
}
?>
