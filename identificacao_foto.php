<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
html, body {
  overflow: hidden;
  background: #fff;
}

/* video, canvas {
  position: absolute;
  border: 1px solid red;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);
  width: 320px;
  height: 260px;
} */

.cartoon {
  position: absolute;
  top: 20%;
  left: 50%;
  transform: translate(-50%, 0%);
  width: 60vmin;
  height: 60vmin;
}

.cartoon div {
  position: absolute;
  box-sizing: border-box;
}

.head {
  width: 65%;
  height: 90%;
  border-radius: 100% / 80% 80% 120% 120%;
  top: -2%;
  left: 50%;
  transform: translate(-50%, 0);
  border: 1vmin #e0e0e0 solid;
}

.frontal-vertical-line {
  border-left: 0.3vmin #e0e0e0 solid;
  height: 100%;
  position:absolute;
  left: 50%;
  transform: translate(-50%, 0);
}

.frontal-horizontal-line {
  border-top: 0.3vmin #e0e0e0 solid;
  width: 100%;
  position:absolute;
  top: 45%;
  left: 50%;
  transform: translate(-50%, 0);
}

.left-vertical-line {
  height: 100%;
  width: 20%;
  border-left: 0.3vmin #e0e0e0 solid;
  border-radius: 40%;
  position:absolute;
  left: 50%;
  transform: translate(-50%, 0);
}

.left-horizontal-line {
  border-top: 0.3vmin #e0e0e0 solid;
  width: 100%;
  position:absolute;
  top: 45%;
  left: 50%;
  transform: translate(-50%, 0);
}



</style>
<body>
  <div id="app-vue">
    <video id="video" preload autoplay loop muted playsinline></video>
      <div class="cartoon hb">
          <div class="head">
            <div class="left-vertical-line"></div>
            <div class="left-horizontal-line"></div>
          </div>
      </div>
  </div>
  <script src="js/vendor/tracking/tracking-min.js"></script>
  <script src="js/vendor/tracking/data/face-min.js"></script>
  <script>
    function init() {
      const video = document.querySelector("video");
      navigator.mediaDevices.getUserMedia({
        video: true
      })
      .then(stream => {
        video.srcObject = stream;
        video.play()
        .then(() => {
          const canvas = document.querySelector("canvas");
          const ctx = canvas.getContext("2d");
          const tracker = new tracking.ObjectTracker("face");
          tracking.track('#video', tracker, { camera: true });
          tracker.on('track', event => {
            console.log(event)
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            event.data.forEach(rect => {
              ctx.strokeStyle = "#a64ceb";
              ctx.lineWidth = 2;
              ctx.strokeRect(rect.x, rect.y, rect.width, rect.height);
        });
      })
        })

      })
      .catch()

    }

    window.onload = init()
  </script>
</body>
</html>