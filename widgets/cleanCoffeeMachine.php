<!--
    CLEAN COFFEE MACHINE WIDGET
    This widget periodically appoints a present Coffee Machine User ('cleaner')
    to clean the coffee machine
    @authors: Paul
-->

<?php
require_once('handlers/CacheJSON.php');
$CLEANER_FILE_PATH = "cleaner";
$cache = new CacheJSON($CLEANER_FILE_PATH);
$currentDay = date('d', time());

function isRefreshNeeded($cache): bool
{
    global $currentDay;
    $refresh = false;
    $data = $cache->fetch();
    if (!empty($data->timeCleanCoffeeMachine)) {
        if ($currentDay !== $data->timeCleanCoffeeMachine) {
            $refresh = true;
        }
    }
    if(empty($data->coffeeCleanerId)) {
        $refresh = true;
    }
    return $refresh;
}

function setRandomCleaner($presentCoffeeMachineUsers, $cache)
{
    global $currentDay;
    $randomIndex = array_rand($presentCoffeeMachineUsers, 1);
    $randomMemberId = $presentCoffeeMachineUsers[$randomIndex]->getId();
    $data = [];
    $data['coffeeCleanerId'] =  $randomMemberId;
    $data['timeCleanCoffeeMachine'] =  $currentDay;
    $cache->store($data);

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
        $refresh = isRefreshNeeded($cache);
        if ($refresh) {
            setRandomCleaner($presentCoffeeMachineUsers, $cache);
        }

        $data = $cache->fetch();
        $cleaner = $allMembers[$data->coffeeCleanerId];
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
