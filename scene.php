<?php
    include("install.php");
    include("header.php");
    if (!isset($_SESSION['loggued_on_user']) && $_SESSION['loggued_on_user'] !== "") {
        header("Location: index.php");
        return;
    }
 ?>
 <br>


<div id="webcam">
<video id="video"></video>
<canvas id="canvas"></canvas>


<canvas id="photo" ></canvas>
</div>
<!-- <canvas id="canvas2" ></canvas> -->

<button id="startbutton">Prendre une photo</button>
<canvas id="overlay"></canvas>
<canvas id="res" hidden ></canvas>
<input type="file" id="fileUpload" onchange="handleFiles(this.files)" >
<form action="">
<div id="filters" >
<?php
  $dir = new DirectoryIterator(dirname(__FILE__).'/filters');
foreach ($dir as $fileinfo) {
    if (!$fileinfo->isDot()) {
        $src = 'filters/'.$fileinfo->getFilename();
        echo "<input type=\"radio\" name=\"filter\" value=\"$src\" ><img class=\"filter\" src=$src ></img>";
    }
}
?>
</div>
</form>
<div id="mypics" >
<?php
  try {
      $query = 'SELECT * FROM users WHERE username=:username;';
      $prep = $pdo->prepare($query);
      $prep->bindValue(':username', $_SESSION['loggued_on_user'], PDO::PARAM_STR);
      $prep->execute();
      $arr = $prep->fetchAll();
      $id_user = $arr[0][id];
      $prep->closeCursor();
      $prep = null;
      $query = 'SELECT * FROM images WHERE id_user=:id_user;';
      $prep = $pdo->prepare($query);
      $prep->bindValue(':id_user', $id_user, PDO::PARAM_INT);
      $prep->execute();
      $arr = $prep->fetchAll();
    // print_r($arr);
      foreach ($arr as $image) {
          echo "<div class=\"image\" ><img src=\"$image[path]\"></img>";
          print("<form action=\"delete_image.php\" method=\"post\">
                <input type=\"hidden\" name=\"id_image\" value=$image[id] >
                <input type=\"submit\" value=\"delete\" >
                </form></div>
                ");
      }
  } catch (PDOException $e) {
      $msg = 'ERREUR PDO dans ' . $e->getFile() . ' L.' . $e->getLine() . ' : ' . $e->getMessage();
      die($msg);
  }

?>

</div>
<!-- <img src="http://placekitten.com/g/320/261" id="photo" alt="photo"> -->
	<script src="cam.js" ></script>
</html>
