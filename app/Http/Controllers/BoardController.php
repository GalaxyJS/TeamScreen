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

    return $content;
  }
}
