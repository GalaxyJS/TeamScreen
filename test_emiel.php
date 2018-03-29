<!DOCTYPE html>
<html>
<head>
    <title>Test Emiel</title>
</head>
<body>

<p/>
<a href="views/addmember.php">Lid toevoegen</a>
<p/>

<?php
require_once('models/Member.php');
require_once('models/Team.php');
require_once('handlers/Database.php');
require_once('handlers/MemberHandler.php');
require_once('handlers/TeamHandler.php');

$team = new Team(1, 'testteam');
$member = new Member(1, 'user01', 'klaas', $team);

// echo 'Naam: ' . $member->getName() ;
// echo '<br/><br/>';
// print_r($team);

$datetime = new DateTime();
$datetime = date_create("2018-03-28 16:59:00");

echo date_format($datetime,"d/m/Y H:i:s") . '<br>';

$date = $datetime->format('d/m/Y');
$time = $datetime->format('H:i:s');
echo $date, ' | ', $time , '<br>';

echo 'Vóór negenen? ';
echo ((int) $time < 9 ? 'Ja' : 'Nee') . '<br>';
echo 'Na vijven? ';
echo ((int) $time >= 17 ? 'Ja' : 'Nee') . '<br>';

echo 'kantooruren? ';
echo ((int) $time >= 9 && (int) $time < 17 ? 'Ja' : 'Nee') . '<br>';
echo (int) $time >= 9 && (int) $time < 17 ;

echo '<p/>';

$json = '{"a":1,"b":2,"c":3,"d":4,"e":5}';

//var_dump(json_decode($json));
//var_dump(json_decode($json, true));

$array = json_decode( $json, true );
var_dump($array);

foreach($array as $item) {
    echo $item.'<br/>';
}

echo '<p/>';

$db = new Database();
$conn = $db->getConnection();
$memberHandler = new MemberHandler($conn);
$teamMembers = $memberHandler->getByTeam((int) 1);


//var_dump($teamMembers[0]);
$presentTeamMember = null;

for($i = 0; $i < sizeof($teamMembers); $i++){

//foreach($teamMembers as $teamMember) {

    echo $teamMembers[$i]->getName().'<br/>';

    $workingDays = $teamMembers[$i]->getWorkingDays();
    //echo $workingDays .'<br/>';

    foreach(explode(",", $workingDays) as $workingDay) {

        $day = date('l', time());

        if(strcmp($workingDay, strtolower($day)) == 0){
            echo $teamMembers[$i]->getName().'<br/>';
            $presentTeamMembers[$i] = $teamMembers[$i];
            //array_push($presentTeamMember, $teamMembers[$i]);
        }
    }
}

echo '<p/>';
if(isset($presentTeamMembers[0])) {
    var_dump($presentTeamMember);
    echo $presentTeamMembers[0]->getName();
}


?>

</body>
</html>
}