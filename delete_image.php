<?php
session_start();
include "header.php";
include "install.php";

try {
    $query = 'DELETE FROM comments WHERE id_image=:id_image;';
    $prep = $pdo->prepare($query);
    $prep->bindValue(':id_image', $_POST['id_image'], PDO::PARAM_INT);
    $prep->execute();
    $prep->closeCursor();
    $prep = null;
    $query = 'DELETE FROM likes WHERE id_image=:id_image;';
    $prep = $pdo->prepare($query);
    $prep->bindValue(':id_image', $_POST['id_image'], PDO::PARAM_INT);
    $prep->execute();
    $prep->closeCursor();
    $prep = null;
    $query = 'DELETE FROM images WHERE id IN (:id_image);';
    $prep = $pdo->prepare($query);
    $prep->bindValue(':id_image', $_POST['id_image'], PDO::PARAM_INT);
    $prep->execute();
    $prep->closeCursor();
    $prep = null;
} catch (PDOException $e) {
    $msg = 'ERREUR PDO dans ' . $e->getFile() . ' L.' . $e->getLine() . ' : ' . $e->getMessage();
    die($msg);
}
    header("Location: scene.php");
    return;
?>
