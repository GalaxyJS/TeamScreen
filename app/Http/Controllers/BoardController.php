<?php

namespace App\Http\Controllers;

class BoardController extends Controller {
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct () {
    //
  }

  //

  public function getActiveSprint ($board_id) {
    $content = file_get_contents("http://tim.mybit.nl/jiraproxy.php/rest/agile/1.0/board/{$board_id}/sprint?state=active");

    if (empty($content)) {
      $exception = new \Exception("Board '{$board_id}' not found", 404);

      return $exception;
    }

    return response($content);
  }

  public function getBoardConfiguration ($board_id) {
    $content = file_get_contents("http://tim.mybit.nl/jiraproxy.php/rest/agile/1.0/board/{$board_id}/configuration");

    if (empty($content)) {
      $exception = new \Exception("Board '{$board_id}' not found", 404);

      return $exception;
    }

    return response($content);
  }

  public function getSprintIssues ($board_id, $sprint_id) {
    $url = "http://tim.mybit.nl/jiraproxy.php/rest/agile/1.0/board/{$board_id}/sprint/{$sprint_id}/issue";

    $content = file_get_contents($url);

    if (empty($content)) {
      $exception = new \Exception("Board '{$board_id}' not found", 404);

      return $exception;
    }

    $jsonfied_content = json_decode($content);
    return response()->json($jsonfied_content);
  }
}
