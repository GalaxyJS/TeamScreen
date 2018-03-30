<?php

require_once('../../handlers/Database.php');
require_once('../../models/Member.php');
require_once('../../handlers/MemberHandler.php');
require_once('../../handlers/TeamHandler.php');

/**
 *
 * CONTROLLER: ADD A MEMBER
 *
 * Authors: Dominic Dingena & Agung Udijana
 * Editor: Carina Boom
 */

/**
 * Connect to database and initialise handlers
 */
$db = new Database();
$dbh = $db->getConnection();
$memberHandler = new MemberHandler($dbh);
$teamHandler = new TeamHandler($dbh);

/**
 * Handle GET-request
 */
if ($_SERVER['REQUEST_METHOD'] === 'GET'){

    $usernames = [];
    $members = $memberHandler->getAll();
    foreach($members as $member){
        array_push($usernames, $member->getUsername());
    }
    $teams = $teamHandler->getAll();

    $addSuccess ="";

    require_once('../../views/addmember.php');
    die();
}

/**
 * Handle POST-request
 */
elseif ($_SERVER['REQUEST_METHOD'] === 'POST'){

    $member = new Member();
    $member->setUsername($_POST['username']);
    $member->setName($_POST['name']);
    $member->setDestination($_POST['destination']);
    $member->setDrinkPreference($_POST['drinkPreference']);
    $member->setTeamId($_POST['team']);
    $workingDays = $_POST['workingDays'];
    if(isset($workingDays)){
        $member->setWorkingDays(implode(',',$workingDays));
    }

    if($memberHandler->add($member)){
            session_start();
            $_SESSION['addValidAddress'] = "Lid succesvol toegevoegd";

        //Redirect to add.php
        header('Location: add.php');
        die();
    }

    //If ADD did not succeed
    die("fatal error");

}
