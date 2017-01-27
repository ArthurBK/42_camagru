<?php
session_start();
include "header.php";
include "install.php";
if (isset($_SESSION['loggued_on_user']) && $_SESSION['loggued_on_user'] !== "") {
    header("Location: scene.php");
}
try {
    $query = 'SELECT * FROM users WHERE email=:email';
    $prep = $pdo->prepare($query);
    $prep->bindValue(':email', $_POST['email'], PDO::PARAM_INT);
    $prep->execute();
// print($prep->rowCount());
    if ($prep->rowCount() == 1) {
        $arr = $prep->fetch();
        $prep->closeCursor();
        $prep = null;
        $token = bin2hex(openssl_random_pseudo_bytes(16));

        $query = 'INSERT INTO tokens(id_user, token) VALUES (:id_user, :token)';
        $prep = $pdo->prepare($query);
        $prep->bindValue(':id_user', $arr[id], PDO::PARAM_INT);
        $prep->bindValue(':token', $token, PDO::PARAM_INT);
        $prep->execute();
        $email = $_POST['email'];
        $subject = 'Reinitialisation de mot de passe';
        $message = 'Bonjour http://localhost:3000/reset_passwd_token?token='.$token;
        $boundary = "-----=".md5(rand());
        $header = "From: \"WeaponsB\"<weaponsb@mail.fr>\n";
        $header .= "Reply-to: \"WeaponsB\" <weaponsb@mail.fr>\n";
        $header .= "MIME-Version: 1.0\n";
        $header .= "Content-Type: multipart/alternative;\n"." boundary=\"$boundary\"\n";
        mail($email, $subject, $message);
    }

    $prep->closeCursor();
    $prep = null;
    header("Location: index.php");
    return;
//
} catch (PDOException $e) {
    $msg = 'ERREUR PDO dans ' . $e->getFile() . ' L.' . $e->getLine() . ' : ' . $e->getMessage();
    die($msg);
}
