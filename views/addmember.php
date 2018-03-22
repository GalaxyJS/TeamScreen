<?php require_once('../header.php');


/*
 Authors: Petri van Niekerk & Agung Udijana
*/

session_start();
if(isset($_SESSION['addSuccess'])) {
    $success = $_SESSION['addSuccess'];
}
else {
    $success ='';
}
unset($_SESSION['addSuccess']);

?>



    <title>Nieuw teamlid</title>
</head>
<body>

<div id="general">

    <h1>Nieuw teamlid</h1>

    <h2><?= $success ?> </h2>

    <form action="./add.php" method="post">
        <table>
            <tr>
                <td><label for="name">Naam</label> </td>
                <td> <input type="text" name="name"/></td>
            </tr>
            <tr>
                <td><label for ="username">Jira gebruikersnaam</td>
                <td><input type="text" name="username" /></td>
            </tr>
            <tr>
                <td><label for ="team">Team</td>
                <td><select name ="team">
                    <option selected="selected">Voeg toe aan team</option>
                    <?php
                    // Iterating through the array that contains the teams which are passed on by the handler
                    foreach($teams as $team){
                    ?>
                    <option value="<?= $team->getId() ?>"><?= $team->getLabel() ?></option>
                    <?php
                    }
                    ?>
                </select>
                </td>
            </tr>

            <tr>
                <td><label for ="destination">Bestemming</td>
                <td><input type="text" name="destination"/></td>
            </tr>
            <tr>
                <td><label for ="drinkPreference">Drankvoorkeur</td>
                <td><select name="drinkPreference">
                    <option selected="selected">Kies een drankvoorkeur</option>


                    <?php
                    // Iterating through the array that contains the drink preferences which are passed on by the handler
                    foreach($drinkPreferences as $item){
                    ?>
                    <option value="<?php echo strtolower($item); ?>"><?php echo $item; ?></option>
                    <?php
                    }
                    ?>
                </select>
                </td>
            </tr>

            <tr>
                <td><label for ="workingDays[]">Werkdagen</td>
                <td>
                    <input type="checkbox" name="workingDays[]" value="Monday" checked>Maandag<br>
                    <input type="checkbox" name="workingDays[]" value="Tuesday" checked>Dinsdag<br>
                    <input type="checkbox" name="workingDays[]" value="Wednesday" checked>Woensdag<br>
                    <input type="checkbox" name="workingDays[]" value="Thursday" checked>Donderdag<br>
                    <input type="checkbox" name="workingDays[]" value="Friday" checked>Vrijdag<br>
                </td>
            </tr>
        </table>

        <br>
        <br>

        <button type="submit" name="addMemberButton">Maak teamlid aan</button>

    </form>


</div>

</body>


</html>
