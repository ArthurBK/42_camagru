<?php
session_start();
include "config/setup.php";

try {
    $query = 'SELECT * FROM users WHERE username=:username;';
    $prep = $pdo->prepare($query);
    $prep->bindValue(':username', $_SESSION['logged'], PDO::PARAM_STR);
    $prep->execute();
    $arr = $prep->fetchAll();
    $id_user = $arr[0][id];
    $prep->closeCursor();
    $prep = null;
    $query = 'SELECT * FROM likes WHERE id_user=:id_user AND id_image=:id_image;';
    $prep = $pdo->prepare($query);
    $prep->bindValue(':id_image', $_POST['id_image'], PDO::PARAM_INT);
    $prep->bindValue(':id_user', $id_user, PDO::PARAM_INT);
    $prep->execute();
    if ($prep->rowCount() == 1) {
        $arr = $prep->fetch();
        $query = 'UPDATE likes SET liked=:liked WHERE id_user=:id_user AND id_image=:id_image';
        $prep = $pdo->prepare($query);
        $prep->bindValue(':id_image', $_POST['id_image'], PDO::PARAM_INT);
        $prep->bindValue(':id_user', $id_user, PDO::PARAM_INT);
        if ($arr[liked] == true) {
            $prep->bindValue(':liked', false, PDO::PARAM_LOB);
        } else {
            $prep->bindValue(':liked', true, PDO::PARAM_LOB);
        }
        $prep->execute();
        $prep->closeCursor();
        $prep = null;
    } else {
        $prep->closeCursor();
        $prep = null;
        $query = 'INSERT INTO likes(id_user, id_image, liked) VALUES (:id_user, :id_image, :liked);';
        $prep = $pdo->prepare($query);
        $prep->bindValue(':id_user', $id_user, PDO::PARAM_INT);
        $prep->bindValue(':id_image', $_POST['id_image'], PDO::PARAM_INT);
        $prep->bindValue(':liked', true, PDO::PARAM_LOB);
        $prep->execute();
        $prep->closeCursor();
        $prep = null;
    }
} catch (PDOException $e) {
    $msg = 'ERREUR PDO dans ' . $e->getFile() . ' L.' . $e->getLine() . ' : ' . $e->getMessage();
    die($msg);
}
    header("Location: index.php");
    return;
?>
