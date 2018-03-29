<?php
require_once('../header.php');

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
$success = isset($_SESSION['editSuccess']) ? $_SESSION['editSuccess'] : '';
unset($_SESSION['editSuccess']);
?>

<div id="general">

    <h1>Wijzig teamlid</h1>

    <h2><?= $success ?></h2>

    <form action="./edit.php" method="post">


        <table>
            <input type="hidden" value="<?= $member->getId(); ?>" name="id" />
            <tr>
                <td><label for="name">Naam</label> </td>
                <td> <input type="text" name="name" value="<?php echo $member->getName(); ?>"></td>
            </tr>
            <tr>
                <td><label for ="username">Jira gebruikersnaam</td>
                <td><input type="text" name="username" value ="<?php echo $member->getUsername(); ?>"></td>
            </tr>
            </tr>
            <tr>
                <td><label for ="team">Team</td>
                <td><select name ="team">
                        <?php
                        // Iterating through the array that contains the teams which are passed on by the handler
                        foreach($teams as $team){
                            $teamId = $team->getId();
                            ?>
                            <option value="<?= $teamId ?>" <?php if($teamId == $member->getTeamId()){echo "selected";}?> > <?= $team->getLabel() ?></option>
                            <?php
                            }
                            ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td><label for ="destination">Bestemming</td>
                <td><input type="text" name="destination" value="<?php echo $member->getDestination(); ?>"></td>
            </tr>
            <tr>
                <td><label for ="drinkPreference">Drankvoorkeur</td>
                <td><select name="drinkPreference">
                        <?php
                        // Iterating through the array that contains the drink preferences which are passed on by the handler
                        foreach($drinkPreferences as $item => $itemNL){
                            ?>
                            <option value="<?php echo strtolower($item); ?>" <?php if($item == $member->getDrinkPreference()){echo "selected";}?> ><?php echo $itemNL; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td><label for ="workingDays[]">Werkdagen</td>
                <td>
                    <?php
                    foreach($workingDays as $day => $dayNL){
                        echo "<input type='checkbox' name='workingDays[]' value='$day'";
                        if (in_array(strtolower($day), explode(',', $member->getWorkingDays()))) echo " checked";
                        echo ">$dayNL<br>";
                    }
                    ?>
                </td>
            </tr>
        </table>

        <br>
        <br>

        <button type="submit" name="editMemberButton">Sla wijzigingen op</button>
    </form>

    <br>

    <button name="deleteMemberButton" onclick="clicked(event)">Verwijder lid</button>


</div>

</body>


</html>

<!-- added by AU. 21.03.2018 - Delete confirmation -->
<script>
    function clicked(e)
    {
        if(!confirm('Weet je zeker dat je dit lid wilt verwijderen?')) {
            e.preventDefault();
        }
        else {
            var form = document.createElement('form');
            document.body.appendChild(form);
            form.method = 'post';
            form.action = 'delete.php';
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'id';
            input.value = <?= $member->getId() ?>;
            form.appendChild(input);
            form.submit();
        }
    }
</script>


