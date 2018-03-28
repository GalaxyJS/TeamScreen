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

    <h1>Nieuw team</h1>

    <h2><?= $success ?> </h2>
    <form action="./add.php" method="post">

                <label for="name">Team naam</label>
               <input type="text" name="name"/>

        <button type="submit" class="button2" >Maak team aan</button>
    </form>


</div>

</body>


</html>
