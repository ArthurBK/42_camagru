<?php
session_start();
include "header.php";
include "config/setup.php";
if (isset($_SESSION['loggued_on_user']) && $_SESSION['loggued_on_user'] !== "") {
    header("Location: index.php");
    return;
}
try {
    $query = 'SELECT * FROM tokens WHERE token=:token';
    $prep = $pdo->prepare($query);
    $prep->bindValue(':token', $_GET['token'], PDO::PARAM_INT);
    $prep->execute();
    if ($prep->rowCount() < 1) {
    header("Location: index.php");
    $prep->closeCursor();
    $prep = null;
    return;
    }
    $prep->closeCursor();
    $prep = null;
} catch (PDOException $e) {
    $msg = 'ERREUR PDO dans ' . $e->getFile() . ' L.' . $e->getLine() . ' : ' . $e->getMessage();
    die($msg);
};
?>

<div style="text-align: center;">
<form class="" action="reset_passwd.php" method="post">
  <input type="password" name="password" value="">
  <input type="submit" name="" value="Confirm">
  <input hidden type="text" name="token" value=<?php echo htmlspecialchars($_GET['token']) ?> >
</form>
</div>
