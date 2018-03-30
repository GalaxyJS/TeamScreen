<?php

require_once('../../handlers/Database.php');
require_once('../../models/Member.php');
require_once('../../handlers/MemberHandler.php');
require_once('../../handlers/TeamHandler.php');

/**
 * CONTROLLER: EDIT A MEMBER
 *
 * Authors: Dominic Dingena & Agung Udijana
 * Editor: Carina Boom
 */

$db = new Database();
$conn = $db->getConnection();
$memberHandler = new MemberHandler($conn);
$teamHandler = new TeamHandler($conn);

/**
 * GET-method
 */
if ($_SERVER['REQUEST_METHOD'] === 'GET'){
    if(!isset($_GET['id'])){
        die();
    }
    $id = (int) $_GET['id'];

    $editSuccess ='';

    $member = $memberHandler->get($id);
    if(!$member) die("Member not found.");

    $members = $memberHandler->getAll();

    $editSuccess ='';

    $teams = $teamHandler->getAll();

    require_once('../../views/member/edit.php');
}

/**
 * POST-method
 */
elseif ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $member = new Member();
    $member->setId($_POST['id']);
    $member->setUsername($_POST['username']);
    $member->setName($_POST['name']);
    $member->setDestination($_POST['destination']);
    $member->setDrinkPreference($_POST['drinkPreference']);
    $member->setTeamId($_POST['team']);
    $workingDays = $_POST['workingDays'];
    if(isset($workingDays)){
        $member->setWorkingDays(implode(',',$workingDays));
    }

    $memberHandler->update($member);

    session_start();
    $_SESSION['editSuccess'] = "Lid succesvol gewijzigd";

    //Redirect to edit member by id
    header('Location: edit.php?id=' . $member->getId());

    die();

}
