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
    const CLEAN_COFFEE_REFRESH = 60 * 60 * 24;

    if (empty($presentCoffeeMachineUsers)) {
        echo '<div id="cleanerTxt">Er is op dit moment niemand beschikbaar.</div>';
    } else {
        $refresh = true;
        if (isset($_SESSION['timeCleanCoffeeMachine'])) {
            //24 hr refresh
            $refresh = (time() - $_SESSION['timeCleanCoffeeMachine']) >= CLEAN_COFFEE_REFRESH;
        }

        if ($refresh) {
            //picks a random member of the presentCoffeeMachineUsers list
            $randomIndex = array_rand($presentCoffeeMachineUsers, 1);
            $randomMember = $presentCoffeeMachineUsers[$randomIndex];
            $randomMemberId = $randomMember->getId;
            // TODO use member id
            $_SESSION['coffeeCleanerId'] = $randomMemberId;
            $_SESSION['timeCleanCoffeeMachine'] = time();
        }
        $cleaner = ($presentCoffeeMachineUsers[$_SESSION['coffeeCleanerId']]);
        ?>
        <div id="cleanerAvatar">
            <img src="http://tim.mybit.nl/jiraproxy.php/secure/useravatar?ownerId=<?= $cleaner->getUsername() ?>"/>
        </div>
        <div id="cleanerTxt">
            <span class="fat"><?= $cleaner->getName() ?></span>, jij gaat vandaag het koffieapparaat schoonmaken!
        </div>
    <?php } ?>
</div>
