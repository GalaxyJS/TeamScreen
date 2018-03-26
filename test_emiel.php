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


echo '<p/>';

$json = '{"a":1,"b":2,"c":3,"d":4,"e":5}';

//var_dump(json_decode($json));
//var_dump(json_decode($json, true));

$array = json_decode( $json, true );
var_dump($array);

foreach($array as $item) {
    //echo $item['filename'];
    echo $item.'<br/>';
    echo $item['a'];
}


$db = new Database();
$conn = $db->getConnection();
$memberHandler = new MemberHandler($conn);
$teamMembers = $memberHandler->getByTeam((int) 1);


//var_dump($teamMembers[0]);

$workingDays = $teamMembers[0]->getWorkingDays();

//echo explode(",", $workingDays)[1];

foreach(explode(",", $workingDays) as $item) {
    //echo $item['filename'];
    $day = date('l', time());
    echo $item;
    echo ' Today? ' . strcmp($item, strtolower($day)) ;
    echo '<br/>';
}

echo '<p/>';
$cars[0] = "Volvo";
$cars[1] = "BMW";
$cars[2] = "Toyota";

echo $cars[2];

?>

</body>
</html>