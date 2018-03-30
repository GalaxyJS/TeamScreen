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
        //$datetime=date_create("2018-03-29 8:15:00");
        $time = $datetime->format('H:i:s');        //$date = $datetime->format('d/m/Y');

        /** Only refresh during office hours (between 09:00 and 17:00)  */
        $officeHours = (int) $time >= 9 && (int) $time < 17;

        $refresh = false;
        if ($officeHours == 1) {
            if (isset($_SESSION['timeTeamDrinks'])) {
                /** Previous refresh has occurred. Check the interval in seconds since last refresh */
                if (time() - $_SESSION['timeTeamDrinks'] < 3600){
                    if(!isset($presentTeamMembers[$_SESSION['teams'][$teamId]['waiterId']])){
                        // *bugfix* Selected waiter has since the last refresh been removed the list of
                        // present team members; time off data may have been update to include today.
                        $refresh = true;
                    }
                }
                else{
                    // Interval > 1 hour: refresh!
                    $refresh = true;
                }
            }
            /** Session variable is not set. */
            else {
                $_SESSION['timeTeamDrinks'] = time();
                $refresh = true;
            }
        }
        // outside office hours
        else{
            // Determine a waiter ONCE outside office hours
            $refresh = !isset($_SESSION['timeTeamDrinks']);
        }
        // TODO remove
        $refresh = true;

        /** Randomly appoint the new waiter */
        if($refresh){
            foreach($teams as $team) {
                $presTeamMembers = $teamMembers;
                if(!empty($presTeamMembers)) {
                    $randomPresentTeamMember = $presTeamMembers[array_rand($presTeamMembers, 1)];
                    $_SESSION['teams'][$team->getId()]['waiterId'] = $randomPresentTeamMember->getId();
                }
            }
            $_SESSION['timeTeamDrinks'] = time();
        }

        /** Are team members present? */
        if(empty($presentTeamMembers)){
            // no one of the team is present on a specific day
            echo '<img src="widgets/void.jpg">Er is op dit moment niemand beschikbaar.';
        }
        else{
            $waiter = $presentTeamMembers[$_SESSION['teams'][$teamId]['waiterId']];
            echo '<img src="http://tim.mybit.nl/jiraproxy.php/secure/useravatar?size=large&ownerId=' . $waiter->getUsername() . '">';
            echo '<span class="name">' . $waiter->getName() . '</span>, het is jouw beurt om koffie te halen voor:';
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