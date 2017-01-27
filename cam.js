var fileUpload = document.getElementById("fileUpload");
var viedoStatus = false;

var video = function() {

    var streaming = false,
        video = document.getElementById('video'),
        res = document.getElementById('res'),
        canvas = document.getElementById('canvas'),
        webcam = document.getElementById('webcam'),
        // photo = document.getElementById('photo'),
        mypics = document.getElementById('mypics'),
        startbutton = document.getElementById('startbutton'),
        width = 520,
        height = 0;

    navigator.getUserMedia = (navigator.getUserMedia ||
        navigator.webkitGetUserMedia ||
        navigator.mozGetUserMedia ||
        navigator.msGetUserMedia);

    function handleImage(e) {
        // reader.onload = function(event){
        var img = new Image();
        img.src = e;
        img.onload = function() {
            init(img);
            photo.width = video.width;
            photo.height = video.height;
            // photo.getContext('2d').drawImage(img, photo.width / 2, photo.height / 2, 200 , 200);
        }
        // }
        // reader.readAsDataURL(e);
    }

    navigator.getUserMedia({
            video: true,
            audio: false
        },
        function(stream) {
            var video = document.querySelector('video');
            video.src = window.URL.createObjectURL(stream);
            if (navigator.mozGetUserMedia) {
                video.mozSrcObject = stream;
            } else {
                var vendorURL = window.URL || window.webkitURL;
                video.src = vendorURL.createObjectURL(stream);
            }
            video.play();
            videoStatus = true;
        },
        function(err) {
            console.log("An error occured! " + err);
        }
    );

    function drawFrame() {
        // var canvas = document.querySelector('canvas'),
        context = canvas.getContext('2d');
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        // overlay.src = URL.createObjectURL('filters/moustache1.png');
        setTimeout(drawFrame, 50);
    }

    var handler = function() {
        for (var i = 1; i < 1000; i++)
            clearInterval(i);
        handleImage(this.value);
    };

    var radios = document.getElementsByName('filter');
    for (var i = radios.length; i--;) {
        radios[i].onclick = handler;
    }



    video.addEventListener('canplay', function(ev) {
        if (!streaming) {
            height = video.videoHeight / (video.videoWidth / width);
            video.setAttribute('width', width);
            video.setAttribute('height', height);
            canvas.setAttribute('width', width);
            canvas.setAttribute('height', height);
            webcam.style.width = width + 'px';
            webcam.style.height = height + 'px';
            streaming = true;
        }
    }, false);

    function httpRequest(type, page, data) {
        var filter = photo.toDataURL('image/png');
        $.ajax({
            type: type,
            url: page,
            data: {
                img: data,
                filter: filter
            },
            success: function(data) {
                // console.log(data);
                location.reload();
                //     var div = document.createElement('div');
                //     var img = new Image();
                //     img.src = data;
                //     img.onload = function() {
                //             res.width = img.width;
                //             res.height = img.height;
                //             // photo.getContext('2d').drawImage(img, 0, 0);
                //             // res.getContext('2d').drawImage(img, 0, 0, width, height);
                //         }
                // // div.className = 'image';
                // // div.innerHTML = '<form action="delete_image.php" method="post"><input type="hidden" name="id_image"value=$image[id] ><input type="submit" value="delete" ></form></div>'
                // div.appendChild(img);
                // mypics.appendChild(div);
            },
        });
    }

    function takepicture() {
        if (videoStatus)
        {
          canvas.width = width;
          canvas.height = height;
          canvas.getContext('2d').drawImage(video, 0, 0, width, height);
        }// else
          // canvas.getContext('2d').drawImage(video, 0, 0, width, height);
        var data = canvas.toDataURL();
        // console.log(data);
        httpRequest('POST', "capture.php", data);
        // photo.setAttribute('src', data);
    }

    startbutton.addEventListener('click', function(ev) {
        takepicture();
        ev.preventDefault();
    }, false);

}();


var canvas;
var ctx;
var x = 0;
var y = 0;
var WIDTH = 400;
var HEIGHT = 400;
var dragok = false;

function rect(x, y, w, h) {
    ctx.beginPath();
    ctx.rect(x, y, w, h);
    ctx.closePath();
    ctx.fill();
}

function clear() {
    ctx.clearRect(0, 0, photo.width, photo.height);
}



var init = function(img) {
    photo = document.getElementById("photo");
    photo.onmouseup = myUp;
    photo.onmousedown = myDown;
    photo.witdh = 400;
    photo.height = 400;
    ctx = photo.getContext("2d");
    return setInterval(function() {
        draw(img);
    }, 10);
}

function draw(img) {
    clear();
    photo.getContext('2d').drawImage(img, x, y, 200, 200);
}

function myMove(e) {
    if (dragok) {
        x = e.pageX - photo.offsetLeft - 100;
        y = e.pageY - photo.offsetTop - 100;
    }
}

function myDown(e) {
    if (e.pageX < x + 200 + photo.offsetLeft && e.pageX > x - 200 +
        photo.offsetLeft && e.pageY < y + 200 + photo.offsetTop &&
        e.pageY > y - 200 + photo.offsetTop) {
        x = e.pageX - photo.offsetLeft - 100;
        y = e.pageY - photo.offsetTop - 100;
        dragok = true;
        photo.onmousemove = myMove;
    }
}

function myUp() {
    dragok = false;
    photo.onmousemove = null;
}


fileUpload.addEventListener("change", handleFiles, false);


function handleFiles(e){
    var reader = new FileReader();
    video = document.getElementById('video'),
    canvas = document.getElementById('canvas');
    video.pause();
    videoStatus = false;
    reader.onload = function(event){
        var img = new Image();
        img.onload = function(){
            canvas.width = video.width;
            canvas.height = video.height;
            canvas.getContext('2d').drawImage(img,0,0);
        }
        img.src = event.target.result;
    }
    reader.readAsDataURL(e.target.files[0]);
}

//
// function handleFiles(e) {
//   var reader = new FileReader();
//   reader.onload = function(event){
//       var img = new Image();
//       img.onload = function(){
//           canvas.width = img.width;
//           canvas.height = img.height;
//           canvas.getContext('2d').drawImage(img,0,0);
//       }
//       img.src = event.target.result;
//   }
//   reader.readAsDataURL(e.target.files[0]);
// }
