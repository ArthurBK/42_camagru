<?php
session_start();
include "header.php";
include "install.php";

try {
    $query = 'SELECT * FROM users WHERE username=:username;';
    $prep = $pdo->prepare($query);
    $prep->bindValue(':username', $_SESSION['loggued_on_user'], PDO::PARAM_STR);
    $prep->execute();
    $arr = $prep->fetchAll();
    $id_user = $arr[0][id];
    $prep->closeCursor();
    $prep = null;
    $query = 'INSERT INTO comments(id_user, id_image, content) VALUES (:id_user, :id_image, :content);';
    $prep = $pdo->prepare($query);
    $prep->bindValue(':id_user', $id_user, PDO::PARAM_INT);
    $prep->bindValue(':id_image', $_POST['id_image'], PDO::PARAM_INT);
    $prep->bindValue(':content', $_POST['content'], PDO::PARAM_LOB);
    $prep->execute();
    $prep->closeCursor();
    $prep = null;
    $query = 'SELECT * FROM IMAGES WHERE id IN (:id_image);';
    $prep = $pdo->prepare($query);
    $prep->bindValue(':id_image', $_POST['id_image'], PDO::PARAM_INT);
    $prep->execute();
    $arr = $prep->fetch();
    $id_user_img = $arr[id_user];
    $prep->closeCursor();
    $prep = null;
    if($arr[id_user] != $id_user)
    {
      $query = 'SELECT * FROM users WHERE id in (:id_user_img);';
      $prep = $pdo->prepare($query);
      $prep->bindValue(':id_user_img', $id_user_img, PDO::PARAM_INT);
      $prep->execute();
      $arr = $prep->fetch();
      $prep->closeCursor();
      $prep = null;
      $email = $arr['email'];
      $subject = 'Nouveau commentaire';
      $message = 'Bonjour, vous avew un nouveau commentaire';
      $boundary = "-----=".md5(rand());
      $header = "From: \"WeaponsB\"<weaponsb@mail.fr>\n";
      $header .= "Reply-to: \"WeaponsB\" <weaponsb@mail.fr>\n";
      $header .= "MIME-Version: 1.0\n";
      $header .= "Content-Type: multipart/alternative;\n"." boundary=\"$boundary\"\n";
      mail($email, $subject, $message);
    }
} catch (PDOException $e) {
    $msg = 'ERREUR PDO dans ' . $e->getFile() . ' L.' . $e->getLine() . ' : ' . $e->getMessage();
    die($msg);
}
    header("Location: index.php");
    return;
?>
