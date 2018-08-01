<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Exception;
use finfo;

class BoardController extends Controller {
  private $context;

  private $api_key;
  private $api_url;
  private $url;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct () {
    $this->api_key = env('JIRA_API_KEY');
    $this->api_url = env('JIRA_API_URL');
    $this->url = env('JIRA_URL');

    $this->context = stream_context_create([
      'http' => [
        'header' => "Authorization: Basic {$this->api_key}"
      ]
    ]);
  }

  private function getUrl (string $path = '', array $query = [], string $host = ''): string {
    $query = http_build_query($query);
    $host = empty($host) ? $this->api_url : $host;
    $url = implode('/', [ $host, $path ]);

    return implode('?', [ $url, $query ]);
  }

  public function getAll (): JsonResponse {
    $request = $this->getUrl('board');

    $content = file_get_contents($request);

    if (empty($content)) {
      $exception = new Exception("Api not available", 500);

      return response()->json([
        'message' => $exception->getMessage()
      ]);
    }

    return response()->json($content);
  }

  public function getActiveSprint (int $board_id): JsonResponse {
    $query = [ 'state' => 'active' ];
    $path = implode('/', [ 'board', $board_id, 'sprint' ]);
    $request = $this->getUrl($path, $query);

    $content = file_get_contents($request, false, $this->context);

    if (empty($content)) {
      $exception = new Exception("Board '{$board_id}' not found", 404);

      return response()->json([
        'message' => $exception->getMessage()
      ]);
    }

    $content = json_decode($content);

    return response()->json($content);
  }

  public function getBoardConfiguration (int $board_id): JsonResponse {
    $path = implode('/', [ 'board', $board_id, 'configuration' ]);
    $request = $this->getUrl($path);

    $content = file_get_contents($request, false, $this->context);

    if (empty($content)) {
      $exception = new Exception("Board '{$board_id}' not found", 404);

      return response()->json([
        'message' => $exception->getMessage()
      ]);
    }

    $content = json_decode($content);

    return response()->json($content);
  }

  public function getSprintIssues (int $sprint_id): JsonResponse {
    $path = implode('/', [ 'sprint', $sprint_id, 'issue' ]);
    $request = $this->getUrl($path);

    $content = file_get_contents($request, false, $this->context);

    if (empty($content)) {
      $exception = new Exception("Board '{$sprint_id}' not found", 404);

      return response()->json([
        'message' => $exception->getMessage()
      ]);
    }

    $content = json_decode($content);

    return response()->json($content);
  }

  public function getAvatar (string $username, string $size = 'xlarge'): Response {
    $query = [ 'ownerId' => $username, 'size' => $size ];
    $path = implode('/', [ 'secure', 'useravatar' ]);
    $request = $this->getUrl($path, $query, $this->url);

    $content = file_get_contents($request, false, $this->context);

    if (empty($content)) {
      throw new Exception("Not found", 404);
    }

    $fileinfo = new finfo(FILEINFO_MIME);

    return response($content, 200, [
      'content-type' => $fileinfo->buffer($content)
    ]);
  }
}
