var video = function() {

    var streaming = false,
        video = document.querySelector('#video'),
        res = document.querySelector('#res'),
        canvas = document.querySelector('#canvas'),
        webcam = document.getElementById('webcam'),
        photo = document.querySelector('#photo'),
        mypics = document.querySelector('#mypics'),
        startbutton = document.querySelector('#startbutton'),
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
            photo.width = img.width;
            photo.height = img.height;
            photo.getContext('2d').drawImage(img, 0, 0);
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
        handleImage(this.value);
        // console.log(this.value);
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
        canvas.width = width;
        canvas.height = height;
        canvas.getContext('2d').drawImage(video, 0, 0, width, height);
        var data = canvas.toDataURL('image/png');
        // console.log(data);
        httpRequest('POST', "capture.php", data);
        // photo.setAttribute('src', data);
    }

    startbutton.addEventListener('click', function(ev) {
        takepicture();
        ev.preventDefault();
    }, false);

}();

//
// function validateEmail(email) {
//     var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
//     return re.test(email);
// }
