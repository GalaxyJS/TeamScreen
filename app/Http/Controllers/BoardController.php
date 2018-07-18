<?php

namespace App\Http\Controllers;

use Exception;
use finfo;

class BoardController extends Controller {
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct () {
    $this->context = stream_context_create([
      'http' => [
        'header' => "Authorization: Basic " . "dGltOjFTbG9nZ2kx"
      ]
    ]);
    //
  }

  public function getAll () {
    $content = file_get_contents("https://jira.local.mybit.nl/rest/agile/1.0/board");

    if (empty($content)) {
      $exception = new Exception("Not found", 404);

      return $exception;
    }

    return response($content);
  }

  public function getActiveSprint ($board_id) {
    $content = file_get_contents("https://jira.local.mybit.nl/rest/agile/1.0/board/{$board_id}/sprint?state=active", false, $this->context);

    if (empty($content)) {
      $exception = new Exception("Board '{$board_id}' not found", 404);

      return $exception;
    }

    return response($content);
  }

  public function getBoardConfiguration ($board_id) {
    $content = file_get_contents("https://jira.local.mybit.nl/rest/agile/1.0/board/{$board_id}/configuration", false, $this->context);

    if (empty($content)) {
      $exception = new Exception("Board '{$board_id}' not found", 404);

      return response()->json([
        'message' => $exception->getMessage()
      ]);
    }

    return response($content);
  }

  public function getSprintIssues ($sprint_id) {
    $url = "https://jira.local.mybit.nl/rest/agile/1.0/sprint/{$sprint_id}/issue";

    $content = file_get_contents($url, false, $this->context);

    if (empty($content)) {
      $exception = new Exception("Board '{$sprint_id}' not found", 404);

      return response()->json([
        'message' => $exception->getMessage()
      ]);
    }

    $jsonfied_content = json_decode($content);

    return response()->json($jsonfied_content);
  }

  public function getAvatar ($username, $size = 'xlarge') {
    $content = file_get_contents("https://jira.local.mybit.nl/secure/useravatar?ownerId={$username}&size={$size}", false, $this->context);

    $fileinfo = new finfo(FILEINFO_MIME);
    $mimetype = $fileinfo->buffer($content);

    if (empty($content)) {
      $exception = new Exception("Not found", 404);

      return $exception;
    }

    return response($content, 200, [
      'content-type' => "{$mimetype}"
    ]);
  }
}
