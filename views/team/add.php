<?php require_once('../header.php');


    /* authors : Agung & Dominic
    22 March 2018 */

session_start();
// TODO shorthand?
if(isset($_SESSION['addValidAddress'])) {
    $success = $_SESSION['addValidAddress'];
}
else {
    $success ='';
}
unset($_SESSION['addValidAddress']);



?>

<div id="general">

    <h1>Nieuw team</h1>

    <h2><?= $success ?> </h2>
    <form action="./add.php" method="post">
        <table>
            <tr>
                <td><label for="name">Team naam</label> </td>
                <td> <input type="text" name="name"/></td>
            </tr>
        </table>

        <br>
        <br>

        <button type="submit" name="addTeam">Maak team aan</button>

    </form>


</div>

</body>


</html>
