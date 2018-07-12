<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>TeamScreen</title>
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css"
        integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
  <link rel="stylesheet" href="assets/css/app.css">

  <script>
    (function () {
      // This will ensure that you boot Galaxy when everything is loaded
      // If you are using JQuery, you can also use $(document).ready(run);
      window.addEventListener('load', run);

      function run() {
        Galaxy.boot({
          // The path to your main module file
          url: 'modules/pages/main.js',
          // The container element for your app
          element: document.querySelector('body')
        }).then(function (module) {
          module.start();
        });
      }
    })();
  </script>
</head>
<body>
<div class="bootstrap-loader"></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cash/2.3.3/cash.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/2.0.1/TweenLite.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/2.0.1/TimelineLite.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/2.0.1/easing/EasePack.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/2.0.1/plugins/CSSPlugin.min.js" defer></script>

<script src="assets/galaxyjs/galaxy.js" defer></script>
</body>
</html>
