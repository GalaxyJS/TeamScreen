<?php

require_once('../../handlers/Database.php');
require_once('../../handlers/TeamHandler.php');

// Get

if ($_SERVER['REQUEST_METHOD'] === 'GET'){
    $db = new Database();
    $conn = $db->getConnection();
    $teamHandler = new TeamHandler($conn);
    $addSuccess ='';

    require_once('../../views/team/add.php');
    die();
}

// Post
elseif ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $label = $_POST['name'];
    $team = new Team();
    $team->setLabel($label);

    $db = new Database();
    $dbh = $db->getConnection();
    $teamHandler = new TeamHandler($dbh);


    if($teamHandler->add($team)){
        session_start();
        $_SESSION['addValidAddress'] = "Team succesvol toegevoegd";

        header('Location: '. './add.php');
        die();
    }
    die("fatal error");

}
