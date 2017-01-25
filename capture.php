<?php
session_start();
include("../install.php");
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
  $path = 'photos/'.time().'.png';
  imagepng($destination, $path);
  echo $path;
  // imagedestroy($source);
  // return ($destination);
  // echo "imagepng($destination)";
  imagedestroy($destination);

 ?>
