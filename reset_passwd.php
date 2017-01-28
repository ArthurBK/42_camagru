<?php
session_start();
include "header.php";
include "config/setup.php";
if ((isset($_SESSION['loggued_on_user']) && $_SESSION['loggued_on_user'] !== "")
|| $_POST['password'] === "") {
    header("Location: index.php");
    return;
}
try {
    $query = 'SELECT * FROM tokens WHERE token=:token';
    $prep = $pdo->prepare($query);
    $prep->bindValue(':token', $_POST['token'], PDO::PARAM_INT);
    $prep->execute();
    if ($prep->rowCount() >= 1) {
        $arr = $prep->fetch();
        $id_user = $arr[id_user];
        $prep->closeCursor();
        $prep = null;
        $query = 'UPDATE users SET password = :password WHERE id=:id_user';
        $prep = $pdo->prepare($query);
        $prep->bindValue(':password', hash('whirlpool', $_POST['password']), PDO::PARAM_STR);
        $prep->bindValue(':id_user', $id_user, PDO::PARAM_INT);
        $prep->execute();
        $prep->closeCursor();
        $prep = null;
        $query = 'DELETE FROM tokens WHERE id_user IN (:id_user)';
        $prep = $pdo->prepare($query);
        $prep->bindValue(':id_user', $id_user, PDO::PARAM_INT);
        $prep->execute();
    }
    $prep->closeCursor();
    $prep = null;
    header("Location: index.php");
    return;
} catch (PDOException $e) {
    $msg = 'ERREUR PDO dans ' . $e->getFile() . ' L.' . $e->getLine() . ' : ' . $e->getMessage();
    die($msg);
};
?>

<div style="text-align: center;">
<form class="" action="reset_passwd.php" method="post">
  <input type="password" name="password" value="">
  <input type="submit" name="" value="Confirm">
</form>
</div>
