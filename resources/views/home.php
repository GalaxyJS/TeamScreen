<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>TeamScreen</title>
  <link href="//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,900" rel="stylesheet">
  <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.1.0/css/all.css"
        integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
  <link rel="stylesheet" href="assets/css/app.css">
  <link rel="stylesheet" type="text/css" href="assets/date-picker/jquery.datetimepicker.min.css"/ >

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

<script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js" defer></script>
<script src="//maps.googleapis.com/maps/api/js?key=AIzaSyA4Nr1bQijl7QINVIwC7JCq7Ljh2FYk_8I" defer></script>
<script src="assets/date-picker/jquery.datetimepicker.full.js" defer></script>
<script src="assets/gsap/TweenLite.min.js" defer></script>
<script src="assets/gsap/TimelineLite.min.js" defer></script>
<script src="assets/gsap/easing/EasePack.min.js" defer></script>
<script src="assets/gsap/plugins/CSSPlugin.min.js" defer></script>

<script src="assets/galaxyjs/galaxy.js" defer></script>
</body>
</html>
