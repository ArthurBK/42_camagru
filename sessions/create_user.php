<?PHP
session_start();
include("../install.php");
if (empty($_POST['password']) || empty($_POST['username'])
 || empty($_POST['email']) || $_POST['submit'] !== "OK") {
    header("Location: new_user.php");
} else {
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
        header("Location: new_user.php");
        $msg = 'ERREUR PDO dans ' . $e->getFile() . ' L.' . $e->getLine() . ' : ' . $e->getMessage();
        die($msg);
    }
    $_SESSION['loggued_on_user'] = $_POST['username'];
    header("Location: ../scene.php");
    return ;
}
?>
