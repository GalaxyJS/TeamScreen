<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>TeamScreen</title>
  <link rel="stylesheet" href="assets/css/app.css">
  <script src="assets/galaxyjs/galaxy.js"></script>
  <script>
    (function () {
      // This will ensure that you boot Galaxy when everything is loaded
      // If you are using JQuery, you can also use $(document).ready(run);
      window.addEventListener('load', run);

      function run() {
        Galaxy.boot({
          // The path to your main module file
          url: 'modules/main/main.js',
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
</body>
</html>
