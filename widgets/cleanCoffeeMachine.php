<!--
    CLEAN COFFEE MACHINE WIDGET
    This widget periodically appoints a present Coffee Machine User ('cleaner')
    to clean the coffee machine
    @authors: Paul
-->

<link rel="stylesheet" href="widgets/cleanCoffeeMachine.css">

<div id="cleanCoffeeMachine" class="widgetBoxSmall">
    <h2><img src="widgets/coffee.png">
        Koffieapparaat schoonmaken</h2>


    <?php
    const CLEAN_COFFEE_REFRESH = 60*60*24;

    $refresh = true;
    if (isset($_SESSION['timeCleanCoffeeMachine'])) {
        //24 hr refresh
        $refresh = (time() - $_SESSION['timeCleanCoffeeMachine']) >= CLEAN_COFFEE_REFRESH;
    }

    if ($refresh) {
        if (empty($presentCoffeeMachineUsers)) {
            echo '<div id="cleanerTxt">Er is op dit moment niemand beschikbaar.</div>';
        } else {

            //picks a random index of the allMembers list
            $randomIndex = array_rand($presentCoffeeMachineUsers, 1);
            // TODO use member id
            $_SESSION['coffeeCleanerId'] = $randomIndex;
            $_SESSION['timeCleanCoffeeMachine'] = time();
        }
//picks the Member-object that belongs to the random index
    }
        $cleaner = ($presentCoffeeMachineUsers[$_SESSION['coffeeCleanerId']]);

        ?>


        <div id="cleanerAvatar">

            <img src="http://tim.mybit.nl/jiraproxy.php/secure/useravatar?ownerId=<?= $cleaner->getUsername() ?>"/>

        </div>

        <div id="cleanerTxt">

            <span class="fat"><?= $cleaner->getName() ?></span>, jij gaat vandaag het koffieapparaat schoonmaken!

        </div>
</div>
