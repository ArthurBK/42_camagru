<?php
session_start();
include "header.php";
include "config/setup.php";
$connected = false;
if (isset($_SESSION['loggued_on_user']) && $_SESSION['loggued_on_user'] !== "")
  $connected = true;
$messagesParPage = 5;
try {
  $query = 'SELECT count(*) AS count FROM images;';
  $prep = $pdo->prepare($query);
  $prep->execute();
  $retour_total = $prep->fetchcolumn();
  $prep->closeCursor();
  $prep = null;
  $nombreDePages=ceil($retour_total/$messagesParPage);
 if(isset($_GET['page'])) // Si la variable $_GET['page'] existe...
 {
     $pageActuelle=intval($_GET['page']);
      if($pageActuelle>$nombreDePages) // Si la valeur de $pageActuelle (le numéro de la page) est plus grande que $nombreDePages...
           $pageActuelle=$nombreDePages;
 }
 else // Sinon
      $pageActuelle=1; // La page actuelle est la n°1
 $premiereEntree=($pageActuelle-1)*$messagesParPage; // On calcul la première entrée à lire
    $query = 'SELECT * FROM images LIMIT :premiereEntree, :messagesParPage;';
    $prep = $pdo->prepare($query);
    $prep->bindValue(':premiereEntree', $premiereEntree, PDO::PARAM_INT);
    $prep->bindValue(':messagesParPage', $messagesParPage, PDO::PARAM_INT);
    $prep->execute();
    $arr = $prep->fetchAll();
    $prep->closeCursor();
    $prep = null;
    echo "<div class=\"gallery\" >";
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
              WHERE comments.id_image=:id_image ORDER BY comments.id;";
        $prep = $pdo->prepare($query);
        $prep->bindValue(':id_image', $image[id], PDO::PARAM_INT);
        $prep->execute();
        $comments = $prep->fetchAll();
        $prep->closeCursor();
        $prep = null;
        $thumb =  json_decode('"\uD83D\uDC4D"');
        // echo "<div class=\"image\" >";
        echo "<div class=\"image\" ><img src=\"$image[path]\"></img>";
        if ($connected){

        print("<form action=\"like.php\" class=\"myform\" method=\"post\">
              <div>$arr[likes]
              <input type=\"submit\" value=$thumb ></div>
              <input type=\"hidden\" name=\"id_image\" value=$image[id] >
              </form>
              ");

        echo "<div class=\"comments\">";
        foreach ($comments as $comment) {
            echo "<div><strong>$comment[username]:</strong> $comment[content]</div>";
        }
        print("</div>
              <form action=\"comment.php\" method=\"post\">
              <input type=\"text\" name=\"content\" >
              <input type=\"hidden\" name=\"id_image\" value=$image[id] >
              ");
        if (isset($_GET['page']))
        {
          $page = $_GET['page'];
          print("<input type=\"hidden\" name=\"page\" value=$page >");
        }
        print("
              <input type=\"submit\" value=\"comment\">
              </form></div>
              ");
    }
else {
        print("<div>$arr[likes] Likes");
        foreach ($comments as $comment) {
            echo "<div>$comment[username]: $comment[content]</div>";
        }
      }
        // echo "</div>";
}
        echo "</div>";
        echo '<p align="center">Page : '; //Pour l'affichage, on centre la liste des pages
        for($i=1; $i<=$nombreDePages; $i++) //On fait notre boucle
        {
             //On va faire notre condition
             if($i==$pageActuelle) //Si il s'agit de la page actuelle...
             {
                 echo ' [ '.$i.' ] ';
             }
             else //Sinon...
             {
                  echo ' <a href="index.php?page='.$i.'">'.$i.'</a> ';
             }
        }
        echo '</p>';

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
