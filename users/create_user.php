<?PHP
session_start();
// include("auth.php");
if (empty($_POST['password']) || empty($_POST['username'])
 || empty($_POST['email']) || $_POST['submit'] !== "OK") {
    header("Location: users/new_user.php");
} else {


  // foreach ($my_array as $key => $value) {
  //   if ($value['login'] === $_POST['login'])
  //   {
  //         header("Location: new_user.php");
  //       return;
  //   }
try {
    $query = 'INSERT INTO users(username, email, password) VALUES (:username, :email, :password);';
    $prep = $pdo->prepare($query);

    $prep->bindValue(':username', $_POST['username'], PDO::PARAM_STR);
    $prep->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
    $prep->bindValue(':password', hash('whirlpool', $_POST['password']), PDO::PARAM_STR);
    $prep->execute();

    $prep->closeCursor();
    $prep = null;
} catch (PDOException $e) {
    $msg = 'ERREUR PDO dans ' . $e->getFile() . ' L.' . $e->getLine() . ' : ' . $e->getMessage();
    die($msg);
}

  // "login" => $_POST['login'],
  // "passwd" => $_POST['passwd'],


  header("Location: scene.php");
  return ;
}
