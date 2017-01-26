<?php
session_start();
include("install.php");
$img = base64_decode(str_replace('data:image/png;base64,','', $_POST['img']));
$filter = base64_decode(str_replace('data:image/png;base64,','', $_POST['filter']));


  // Traitement de l'image source
  $source = imagecreatefromString($filter);
  $largeur_source = imagesx($source);
  $hauteur_source = imagesy($source);
  imagealphablending($source, true);
  imagesavealpha($source, true);
  $percent = 0.5;
  //
  // // Content type
  // header('Content-Type: image/jpeg');

  // // Calcul des nouvelles dimensions
  // list($width, $height) = getimagesize($source);
  $newwidth = $largeur_source * $percent;
  $newheight = $hauteur_source * $percent;

  // // Chargement
  $new = imagecreatetruecolor($newwidth, $newheight);
  // // $source = imagecreatefromjpeg($source);

  // // Redimensionnement
  imagecopyresized($new, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

  // Traitement de l'image destination
  $destination = imagecreatefromString($img);
  $largeur_destination = imagesx($destination);
  $hauteur_destination = imagesy($destination);

  // Calcul des coordonnées pour placer l'image source dans l'image de destination
  $destination_x = ($largeur_destination - $largeur_source)/2;
  $destination_y =  ($hauteur_destination - $hauteur_source)/2;

  // On place l'image source dans l'image de destination
  //imagecopymerge($destination, $source, $destination_x, $destination_y, 0, 0, $largeur_source, $hauteur_source, 100);
  imagecopy($destination, $source, $destination_x, $destination_y, 0, 0, $largeur_source, $hauteur_source);

  // On affiche l'image de destination
  $name = time().'.png';
  $path = 'photos/'.$name;
  imagepng($destination, $path);
  try {
      $query = 'SELECT * FROM users WHERE username=:username;';
      $prep = $pdo->prepare($query);
      $prep->bindValue(':username', $_SESSION['loggued_on_user'], PDO::PARAM_STR);
      $prep->execute();

      $arr = $prep->fetchAll();
      $id_user = $arr[0][id];

      $prep->closeCursor();
      $prep = null;

      $query = 'INSERT INTO images(id_user, name, path) VALUES (:id_user, :name, :path);';
      $prep = $pdo->prepare($query);

      $prep->bindValue(':id_user', $id_user, PDO::PARAM_INT);
      $prep->bindValue(':name', $name, PDO::PARAM_STR);
      $prep->bindValue(':path', $path, PDO::PARAM_STR);
      $prep->execute();

      $prep->closeCursor();
      $prep = null;
  } catch (PDOException $e) {
      // header("Location: new_user.php");
      $msg = 'ERREUR PDO dans ' . $e->getFile() . ' L.' . $e->getLine() . ' : ' . $e->getMessage();
      die($msg);
  }
  echo $path;
  imagedestroy($source);
  imagedestroy($destination);

 ?>
