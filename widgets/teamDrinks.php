<!--
    TEAM DRINKS WIDGET
    This widget periodically appoints a present team member ('the waiter')
    to fetch the drinks for his/her team during office hours.

    @authors: Emiel and Petri
    @review: Carina
-->
<link rel="stylesheet" href="widgets/teamDrinks.css">

<div id="teamDrinks" class="widgetBoxSmall">
    <h2><img src="widgets/coffee.png">
        Tijd voor koffie!</h2>

    <div id="current-waiter">

        <?php
        // array with current possible drink preferences
        $drinkPreferences = ['coffee' => 'koffie', 'tea' => 'thee', 'water' => ' water'];
        /**
         * Determine if a new 'waiter' needs to be appointed.
         * Default refresh rate 3600 = 1 hour.
         */
        $datetime = new DateTime();
        // Test different datetimes
        $datetime=date_create("2018-03-29 8:15:00");
        $time = $datetime->format('H:i:s');        //$date = $datetime->format('d/m/Y');

        /** Only refresh during office hours (between 09:00 and 17:00)  */
        $officeHours = (int) $time >= 9 && (int) $time < 17;

        $refresh = false;
        if ($officeHours == 1) {
            if (isset($_SESSION['timeTeamDrinks'])) {
                $refresh = (time() - $_SESSION['timeTeamDrinks']) >= 3600;
            } /** Session variable is not set. */
            else {
                $_SESSION['timeTeamDrinks'] = time();
                $refresh = true;
            }
        }

        /** Randomly appoint the new waiter */
        if($refresh){
            foreach($teams as $team) {
                $presTeamMembers = $memberHandler->getPresentByTeam($team->getId());
                if(!empty($presTeamMembers)) {
                    $randomPresentTeamMember = $presTeamMembers[array_rand($presTeamMembers, 1)];
                    $_SESSION['teams'][$team->getId()]['waiterId'] = $randomPresentTeamMember->getId();
                }
            }
            $_SESSION['timeTeamDrinks'] = time();
        }

        /** Are team members present? */
        if(!empty($presentTeamMembers) && isset($_SESSION['teams'][$teamId]['waiterId'])){
            $waiter = $presentTeamMembers[$_SESSION['teams'][$teamId]['waiterId']];
            echo '<img src="http://tim.mybit.nl/jiraproxy.php/secure/useravatar?size=large&ownerId=' . $waiter->getUsername() . '">';
            echo '<span class="name">' . $waiter->getName() . '</span>, het is jouw beurt om koffie te halen voor:';
        }
        else{
            $img_html = '<img src="widgets/void.jpg">';
            if(empty($presentTeamMembers)){
                // no one of the team is present on a specific day
                echo $img_html . 'Er is op dit moment niemand beschikbaar.';
            }
            else{
                //$_SESSION['teams'][$teamId]['waiterId'] == NULL ; application started outside office hours
                if ($officeHours == 1) {
                    // Sanity check
                    echo $img_html . '[No waiter during office hours: code should not run here!]';
                }
                else{
                    if ($officeHours = (int)$time < 9) {
                        echo $img_html . 'Er is nog niemand beschikbaar.<br/>Verwachte teamleden voor vandaag:';
                    }
                    else{
                        // De applicatie wordt gestart na vijven
                        echo $img_html . 'Er is niemand meer beschikbaar.<br/>Aanwezig waren vandaag:';
                    }
                }
            }
        }
        ?>
    </div>

    <div class="scrollable" id="drink-list">
        <ul id="drink-items">
            <!-- List the team member that are present today-->
            <?php foreach ($presentTeamMembers as $member) { ?>
                <li class='drink-item'>
                    <img class="userimg"
                         src="http://tim.mybit.nl/jiraproxy.php/secure/useravatar?size=small&ownerId=<?= $member->getUsername(); ?>"/>
                    <span><?= $member->getName(); ?></span>
                    <?php foreach ($drinkPreferences as $item => $itemNL) {
                        if (($member->getDrinkPreference()) == $item) {?>
                            <span class='icon'><img src="widgets/<?= $item ?>.png"/>(<?= $itemNL ?>)</span>
                        <?php } ?>
                    <?php } ?>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>

<!-- Insert WidgetFrameControl.js to animate at frame overflow -->
<script src="widgets/WidgetFrameControl.js" type="text/javascript"></script>