<?php
    include("install.php");
    include("header.php");
    if (isset($_SESSION['loggued_on_user'])) {
        if ($_SESSION['loggued_on_user'] === "") {
            header("Location: index.php");
            return;
        }
    } else {
            header("Location: index.php");
            return;
        }
 ?>

<body>
<video id="video"></video>
<button id="startbutton">Prendre une photo</button>
<canvas id="canvas" hidden></canvas>
<canvas id="photo" hidden></canvas>
<canvas id="res" ></canvas>
<div id="mypics" ></div>
<!-- <img src="http://placekitten.com/g/320/261" id="photo" alt="photo"> -->


</body>
	<script src="cam.js" ></script>
</html>
