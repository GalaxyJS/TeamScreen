<!--
    CLEAN COFFEE MACHINE WIDGET
    This widget periodically appoints a present Coffee Machine User ('cleaner')
    to clean the coffee machine
    @authors: Paul
-->
<?php
require_once('handlers/CacheJSON.php');
require_once('models/Cleaner.php');
$CLEANER_FILE_PATH = "cleaner";
$cache = new CacheJSON($CLEANER_FILE_PATH);
$currentDay = date('d', time());

function isRefreshNeeded($cache): bool
{
    // TODO global not ok.
    global $currentDay;
    $refresh = false;
    $cleaner = $cache->fetch();
    if (!empty($cleaner->lastUpdated)) {
        if ($currentDay !== $cleaner->lastUpdated) {
            $refresh = true;
        }
    }
    if(empty($cleaner->lastUpdated)) {
        $refresh = true;
    }
    return $refresh;
}

function setRandomCleaner($presentCoffeeMachineUsers, $cache)
{
    global $currentDay;
    $randomIndex = array_rand($presentCoffeeMachineUsers, 1);
    $randomMemberId = $presentCoffeeMachineUsers[$randomIndex]->getId();
    $cleaner = new Cleaner();
    $cleaner->member_id=  $randomMemberId;
    $cleaner->lastUpdated=  $currentDay;
    $cache->store($cleaner);

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
        $cleaner = $cache->fetch();
        $member = $allMembers[$cleaner->member_id];
        ?>
        <div id="cleanerAvatar">
            <img src="http://tim.mybit.nl/jiraproxy.php/secure/useravatar?ownerId=<?= $member->getUsername() ?>"/>
        </div>
        <div id="cleanerTxt">
            <span class="fat"><?= $member->getName() ?></span>, jij gaat vandaag het koffieapparaat schoonmaken!
        </div>
    <?php } ?>
</div>
