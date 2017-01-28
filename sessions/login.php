<?PHP
session_start();
include("../config/setup.php");
if (empty($_POST['username'])
 || empty($_POST['password']) || $_POST['submit'] !== "OK") {
    header("Location: login_form.php");
} else {
    try {
        $query = 'SELECT * FROM users WHERE username=:username AND password=:password;';
        $prep = $pdo->prepare($query);

        $prep->bindValue(':username', $_POST['username'], PDO::PARAM_STR);
        $prep->bindValue(':password', hash('whirlpool', $_POST['password']), PDO::PARAM_STR);
        $prep->execute();

        if ($prep->rowCount() == 1)
        {
          $_SESSION['loggued_on_user'] = $_POST['username'];
          header("Location: ../scene.php");
        }
        else
          header("Location: login_form.php");

        $prep->closeCursor();
        $prep = null;
        return ;
    } catch (PDOException $e) {
        // header("Location: login_form.php");
        $msg = 'ERREUR PDO dans ' . $e->getFile() . ' L.' . $e->getLine() . ' : ' . $e->getMessage();
        die($msg);
    }
}
?>
