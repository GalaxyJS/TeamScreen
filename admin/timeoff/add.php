<?php

require_once('../../handlers/Database.php');
require_once('../../models/TimeOff.php');
require_once('../../handlers/MemberHandler.php');
require_once('../../handlers/TimeOffHandler.php');

/**
 * CONTROLLER: ADD TIME OFF TO A MEMBER
 *
 * Authors: Dominic Dingena & Carina Boom
 */

/**
 * Connect to the database and initialise handlers
 */
$db = new Database();
$conn = $db->getConnection();
$memberHandler = new MemberHandler($conn);
$timeOffHandler = new TimeOffHandler($conn);

/**
 * Check if a member exists
 *
 * @param $member
 */
function checkExists($member){
    if(empty($member)){
        die("Member not found");
    }
}

/**
 * Handle GET-request
 */
if ($_SERVER['REQUEST_METHOD'] === 'GET'){
    if(empty($_GET['id'])){
        die("No member id specified.");
    }

    $member = $memberHandler->get((int) $_GET['id']);

    checkExists($member);

    include('../../views/timeoff/add.php');
    die();
}

/**
 * Handle POST-request
 */
elseif($_SERVER['REQUEST_METHOD'] === 'POST'){
    $member = $memberHandler->get((int)$_POST['id']);
    checkExists($member);

    $timeOff = new TimeOff();
    $timeOff->setStartTime($_POST['start'] . ':00');
    $timeOff->setEndTime($_POST['end'] . ':00');
    $timeOff->setMemberId($member->getId());
    if(!$timeOffHandler->add($timeOff)){
        die("Fatal error");
    }

    session_start();
    $_SESSION['message'] = 'Verlof toegevoegd voor ' . $member->getName();
    header('Location: ../member/list.php');
    //If ADD did not succeed:
    die("fatal error");
}