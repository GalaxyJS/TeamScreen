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

        const INTERVAL_GET_COFFEE = 60 * 60;

        /**
         * Check if waiters need to be refreshed.
         * @return bool true if needed; false if not
         */
        function checkRefreshNeeded($teamId, $presentTeamMembers){
            /** Only refresh during office hours (between 09:00 and 17:00)  */
            /**
             * Determine if a new 'waiter' needs to be appointed.
             * Default refresh rate 3600 = 1 hour.
             */
            $datetime = new DateTime();
            // Test different datetimes
            //$datetime=date_create("2018-03-29 8:15:00");
            $time = $datetime->format('H:i:s');        //$date = $datetime->format('d/m/Y');
            $officeHours = (int) $time >= 9 && (int) $time < 17;
            if (!$officeHours) {
                // Determine a waiter ONCE outside office hours
                return  !isset($_SESSION['teams'][$teamId]['timeTeamDrinks']);
            }
            if(!isset($_SESSION['teams'][$teamId]['waiterId'])){
                return true;
            }
            if(!isset($_SESSION['teams'][$teamId]['timeTeamDrinks'])){
                return true;
            }
            if (time() - $_SESSION['teams'][$teamId]['timeTeamDrinks'] > INTERVAL_GET_COFFEE){
                return true;
            }
            if (!isset($presentTeamMembers[$_SESSION['teams'][$teamId]['waiterId']])) {
                return true;
            }
            return false;
        }

        /**
         * Set waiters for all teams
         * @param $teams
         * @param $teamMembers
         */
        function setWaiter($teamId, $presentTeamMembers)
        {
            if (!empty($presentTeamMembers)) {
                $randomPresentTeamMember = $presentTeamMembers[array_rand($presentTeamMembers, 1)];
                $_SESSION['teams'][$teamId]['waiterId'] = $randomPresentTeamMember->getId();
                $_SESSION['teams'][$teamId]['timeTeamDrinks'] = time();
            }
        }

        // array with current possible drink preferences
        $drinkPreferences = ['coffee' => 'koffie', 'tea' => 'thee', 'water' => ' water'];

        /** Randomly appoint the new waiter */
        if(checkRefreshNeeded($teamId, $presentTeamMembers)){
            setWaiter($teamId, $presentTeamMembers);
        }

        /** Are team members present? */
        if(empty($presentTeamMembers)){
            // no one of the team is present on a specific day
            echo '<img src="widgets/void.jpg">Er is op dit moment niemand beschikbaar.';
        }
        else{
            $waiter = $allMembers[$_SESSION['teams'][$teamId]['waiterId']];
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