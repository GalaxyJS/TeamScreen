<?php require_once('../header.php');

/*
 Authors: Petri van Niekerk & Agung Udijana
*/

// array with current possible drink preferences
$drinkPreferences = ['coffee' => 'koffie', 'tea' => 'thee', 'water' => ' water'];

// array with current possible workingdays
$workingDays = ['Monday' => 'Maandag', 'Tuesday' => 'Dinsdag', 'Wednesday' => 'Woensdag', 'Thursday' => 'Donderdag', 'Friday' => 'Vrijdag'];

/* AU. 27 March 2018. outcommented - because now there is already a session_start() call in the header.php that is included in this view,
to prevent this notification : "Notice: session_start(): A session had already been started" */
// session_start();

$success = isset($_SESSION['addSuccess']) ? $_SESSION['addSuccess'] : '';
unset($_SESSION['addSuccess']);
?>

<div id="general">

    <h1>Nieuw teamlid</h1>

    <h2><?= $success ?> </h2>

    <form action="./add.php" method="post">
        <div id = "form">
            <ul>
            <li>
                <span><label for="name">Naam</label> </span>
                <span> <input type="text" name="name"/></span>
            </li>
            <li>
                <span><label for ="username">Jira gebruikersnaam</span>
                <span><input type="text" name="username" /></span>
            </li>
            <li>
                <span><label for ="team">Team</span>
                <span><select name ="team">
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
                </span>
            </li>

            <li>
                <span><label for ="destination">Bestemming</span>
                <span><input type="text" name="destination"/></span>
            </li>
            <li>
                <span><label for ="drinkPreference">Drankvoorkeur</span>
                <span><select name="drinkPreference">
                    <option selected="selected">Kies een drankvoorkeur</option>


                    <?php
                    // Iterating through the array that contains the drink preferences which are passed on by the handler
                    foreach($drinkPreferences as $item => $itemNL){
                    ?>
                    <option value="<?php echo strtolower($item); ?>"><?php echo $itemNL; ?></option>
                    <?php
                    }
                    ?>
                </select>
                </span>
            </li>

                <li>
                    <span><label for="workingDays[]">Werkdagen</span>

                        <ul id="formwerkdagen">
                    <?php
                    foreach ($workingDays as $day => $dayNL) {
                        echo "<li><input type='checkbox' name='workingDays[]' value='$day' checked>$dayNL</li>";
                    }
                    ?> </ul>
                    </li>
                <li>  <button class="button1" submit">Maak teamlid aan</button></li>

            </ul>

        </div>

    </form>

</div>
</body>
</html>
