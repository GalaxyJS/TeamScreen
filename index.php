<?php
require_once('handlers/Database.php');
require_once('handlers/Cache.php');
require_once('handlers/MemberHandler.php');
require_once('handlers/TeamHandler.php');
require_once('handlers/TimeOffHandler.php');

$db = new Database();
$conn = $db->getConnection();
$memberHandler = new MemberHandler($conn);
$teamHandler = new TeamHandler($conn);
$timeOffHandler = new TimeOffHandler($conn);
$teams = $teamHandler->getAll();

if (isset($_GET['teamid'])) {
    $teamId = (int)$_GET['teamid'];
    $allMembers = $memberHandler->getAll();

    $teamMembers = $memberHandler->filterByTeam($allMembers, $teamId);
    $presentAllMembers = $memberHandler->filterPresent($allMembers, $teamId);
    $presentTeamMembers = $memberHandler->filterPresent($teamMembers);
    $presentCoffeeMachineUsers = $memberHandler->filterUsesCoffeeMachine($presentAllMembers);

    $timeOffNextTwoWeeks = $timeOffHandler->getByTeamNextTwoWeeks($teamId);

    $javascriptTeamMembers = [];
    foreach ($teamMembers as $teamMember) {
        $javascriptTeamMembers[] = $teamMember;
    }
}

setlocale(LC_TIME, 'nld_nld');
$date = strftime('%e %B %Y', time());

// 15 minutes refresh
$refreshrate = 900;
session_start();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="<?php echo $refreshrate; ?>">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript">
        <?php if(!empty($teamId)) { ?>
        var allMembers = JSON.parse('<?= json_encode($allMembers)?>');
        var teamMembers = JSON.parse('<?= json_encode($javascriptTeamMembers) ?>');
        <?php } ?>
    </script>
    <script src="main.js"></script>
    <script src="time.js"></script>
    <title>Board</title>
</head>
<body onload="startTime()">

<div id="header">
    <div id="dateTime" class="headerline">
        <span id="date" class="headerBox">&#128197 <?php echo $date; ?></span>
        <span class="headerBox">&#128336</span>
        <span id="clock" class="headerBox"></span></div>
    <div id="bordHeader" class="headerline">
        <span id="name" class="headerBox" "fat"><strong>John Doe</strong></span>
        <span class="headerBox" "fat">|</span>
        <span class="headerBox">
            <?php if (!empty($teamId)) { ?>
             <select name="boardSelector" id="boardSelector">
                 <option value="">Kies een team</option>
                 <?php foreach ($teams as $team) {
                     echo "<option value='{$team->getId()}'";
                     if ($team->getId() == $teamId) echo ' selected';
                     echo ">{$team->getLabel()}</option>";
                 } ?>
            </select>
            <?php } ?>
        </span>
    </div>
</div>

<?php
if (empty($_GET['teamid'])) {
    echo '<div id="select-a-team"><h1>Kies een team:</h1>';
    echo '<ul id="teams">';
    foreach ($teams as $team) {
        echo '<li><a href="?teamid=' . $team->getId() . '">' . $team->getLabel() . '</a></li>';
    }
    echo '</ul></div>';
    die();
}
?>

<div id="board">
    <?php include('widgets/teamDrinks.php'); ?>
    <?php include('widgets/cleanCoffeeMachine.php'); ?>
    <?php include('widgets/timeOff.php'); ?>
    <?php include('widgets/delays.php'); ?>
    <?php include('widgets/scrumboard.php'); ?>
</div>
</body>
</html>
