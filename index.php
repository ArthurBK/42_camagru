<?php
session_start();
include "header.php";
include "install.php";
if (isset($_SESSION['loggued_on_user']))
  $connected = true;

try {
    $query = 'SELECT * FROM images';
    $arr = $pdo->query($query)->fetchAll();

    foreach ($arr as $image) {
        $query = 'SELECT count(*) AS "likes" FROM likes WHERE id_image=:id_image AND liked=:liked;';
        $prep = $pdo->prepare($query);
        $prep->bindValue(':id_image', $image[id], PDO::PARAM_INT);
        $prep->bindValue(':liked', true, PDO::PARAM_BOOL);
        $prep->execute();
        $arr = $prep->fetch();
        $prep->closeCursor();
        $prep = null;
        $query = "SELECT comments.content, users.username FROM comments
              INNER JOIN users ON comments.id_user = users.id
              WHERE comments.id_image=:id_image;";
        $prep = $pdo->prepare($query);
        $prep->bindValue(':id_image', $image[id], PDO::PARAM_INT);
        $prep->execute();
        $comments = $prep->fetchAll();
        $prep->closeCursor();
        $prep = null;
        $thumb =  json_decode('"\uD83D\uDC4D"');
        echo "<div class=\"image\" ><img src=\"$image[path]\"></img></div>";
        print("
              <form action=\"like.php\" method=\"post\">
              <div>$arr[likes] Likes
              <input type=\"submit\" value=$thumb ></div>
              <input type=\"hidden\" name=\"id_image\" value=$image[id] >
              </form>
              ");
        foreach ($comments as $comment) {
            echo "<div>$comment[username]: $comment[content]</div>";
        }
        print("
              <form action=\"comment.php\" method=\"post\">
              <input type=\"text\" name=\"content\" >
              <input type=\"hidden\" name=\"id_image\" value=$image[id] >
              <input type=\"submit\" value=\"comment\">
              </form>
              ");
    }
    // print_r($arr);

    // $prep->closeCursor();
    // $prep = null;
    // return ;
} catch (PDOException $e) {
    // header("Location: login_form.php");
    $msg = 'ERREUR PDO dans ' . $e->getFile() . ' L.' . $e->getLine() . ' : ' . $e->getMessage();
    die($msg);
}
?>
