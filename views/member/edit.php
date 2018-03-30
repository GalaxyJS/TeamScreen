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

    <h1><img src="../../views/member/edit.png">  Wijzig teamlid</h1>

    <div id = "message-block">
        <h2><div id="message"><?= $success ?></div></h2>
    </div>

    <form action="./edit.php" method="post">


        <ul>
            <input type="hidden" value="<?= $member->getId(); ?>" name="id"/>
            <li>
                <span><label for="name">Naam</label> </span> <span> <input type="text" name="name"
                                                                           value="<?php echo $member->getName(); ?>"></span>
            </li>
            <li>
                <span><label for="username">Jira gebruikersnaam</span>
                <span><input type="text" name="username" value="<?php echo $member->getUsername(); ?>"></span>
            </li>
            <li>
                <span><label for="team">Team</span> <span><select name="team">
                        <?php
                        // Iterating through the array that contains the teams which are passed on by the handler
                        foreach ($teams as $team) {
                            $teamId = $team->getId();
                            ?>
                            <option value="<?= $teamId ?>" <?php if ($teamId == $member->getTeamId()) {
                                echo "selected";
                            } ?> > <?= $team->getLabel() ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </span></li>

            <li>
                <span><label for="destination">Bestemming</span> <span><input type="text" name="destination"
                                                                              value="<?php echo $member->getDestination(); ?>"></span>
            </li>
            <li>
                <span><label for="drinkPreference">Drankvoorkeur</span> <span><select name="drinkPreference">
                        <?php
                        // Iterating through the array that contains the drink preferences which are passed on by the handler
                        foreach ($drinkPreferences as $item => $itemNL) {
                            ?>
                            <option value="<?php echo strtolower($item); ?>" <?php if ($item == $member->getDrinkPreference()) {
                                echo "selected";
                            } ?> ><?php echo $itemNL; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </span></li>

            <li>
                <span><label for="workingDays[]">Werkdagen</span> <span>
                     <ul id="form-working-days">
                    <?php
                    foreach ($workingDays as $day => $dayNL) {
                        echo "<li><input type='checkbox' name='workingDays[]' value='$day'";
                        if (in_array(strtolower($day), explode(',', $member->getWorkingDays()))) echo " checked";
                        echo ">$dayNL</li>";
                    }
                    ?></ul>
                </span></li>
        </ul>


        <button type="submit" class="button1">Sla wijzigingen op</button>
    </form>

    <button class="button1" onclick="clicked(event)">Verwijder lid</button>


</div>

</body>


</html>

<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>

<!-- added by AU. 21.03.2018 - Delete confirmation -->
<script>
    function clicked(e) {
        if (!confirm('Weet je zeker dat je dit lid wilt verwijderen?')) {
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


    //When the page has loaded.
    $( document ).ready(function(){
        $('#message').fadeIn('slow', function(){
            $('#message').delay(4000).fadeOut();
        });
    });



</script>


