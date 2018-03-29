<?php require_once('../header.php');


/* authors : Agung & Dominic
22 March 2018 */

/* AU. 27 March 2018. outcommented - because now there is already a session_start() call in the header.php that is included in this view,
to prevent this notification : "Notice: session_start(): A session had already been started" */
// session_start();

$success = isset($_SESSION['addSuccess']) ? $_SESSION['addSuccess'] : '';
unset($_SESSION['addSuccess']);


?>

<div id="generalteam">

    <h1><img src="../../views/newteam.png"> Nieuw team</h1>

    <div id="messageblock">
        <h2>
            <div id="message"><?= $success ?> </div>
        </h2>
    </div>


    <form action="./add.php" method="post">

        <label for="name">Team naam</label>
        <input type="text" name="name"/>

        <button type="submit" class="button2">Maak team aan</button>
    </form>


</div>


<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script>
    //When the page has loaded.
    $(document).ready(function () {
        $('#message').fadeIn('slow', function () {
            $('#message').delay(4000).fadeOut();
        });
    });
</script>


</body>


</html>


