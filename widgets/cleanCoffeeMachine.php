<!--
    CLEAN COFFEE MACHINE WIDGET
    This widget periodically appoints a present Coffee Machine User ('cleaner')
    to clean the coffee machine
    @authors: Paul
-->

<?php
$currentDay = date('d', time());
$cache = new Cache();

function isRefreshNeeded(): bool
{
    global $cache;
    global $currentDay;
    $refresh = false;
    if ($cache->fetch('timeCleanCoffeeMachine') !== false) {
        $sameDayCheck = $currentDay === $cache->fetch('timeCleanCoffeeMachine');
        if (!$sameDayCheck) {
            $refresh = true;
        }
    }
// deprecated
//    if (isset($_SESSION['timeCleanCoffeeMachine'])) {
//        $sameDayCheck = $currentDay === $_SESSION['timeCleanCoffeeMachine'];
//        if (!$sameDayCheck) {
//            $refresh = true;
//        }
//    }
    if ($cache->fetch('coffeeCleanerId') == false) {
        $refresh = true;
    }
// depracated
//    if (!isset($_SESSION['coffeeCleanerId'])) {
//        $refresh = true;
//    }
    return $refresh;
}

function setRandomCleaner($presentCoffeeMachineUsers)
{
    global $currentDay;
    global $cache;
    $randomIndex = array_rand($presentCoffeeMachineUsers, 1);
    $randomMemberId = $presentCoffeeMachineUsers[$randomIndex]->getId();
    $cache->store('coffeeCleanerId',$randomMemberId);
    $cache->store('timeCleanCoffeeMachine',$currentDay);

// deprecated
//    $_SESSION['coffeeCleanerId'] = $randomMemberId;
//    $_SESSION['timeCleanCoffeeMachine'] = $currentDay;
}

?>

<link rel="stylesheet" href="widgets/cleanCoffeeMachine.css">

<div id="cleanCoffeeMachine" class="widgetBoxSmall">
    <h2><img src="widgets/coffee.png">
        Koffieapparaat schoonmaken</h2>

    <?php
    // No users available
    if (empty($presentCoffeeMachineUsers)) {
        echo '<div id="cleanerTxt">Er is op dit moment niemand beschikbaar.</div>';
    // Users available
    } else {
        $refresh = isRefreshNeeded();
        if ($refresh) {
            setRandomCleaner($presentCoffeeMachineUsers);
        }
        $cleaner = $allMembers[$cache->fetch('coffeeCleanerId')];
        // deprecated
        //$cleaner = $allMembers[$_SESSION['coffeeCleanerId']];
        ?>
        <div id="cleanerAvatar">
            <img src="http://tim.mybit.nl/jiraproxy.php/secure/useravatar?ownerId=<?= $cleaner->getUsername() ?>"/>
        </div>
        <div id="cleanerTxt">
            <span class="fat"><?= $cleaner->getName() ?></span>, jij gaat vandaag het koffieapparaat schoonmaken!
        </div>
    <?php } ?>
</div>
