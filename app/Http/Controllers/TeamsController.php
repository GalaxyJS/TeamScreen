<?php

namespace App\Http\Controllers;

use App\Models\Agendas;
use App\Models\Teams;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TeamsController extends Controller {
  public function getAll (): JsonResponse {
    $content = Teams::with('members')->get();

    return response()->json($content);
  }

  public function get ($id): JsonResponse {
    $content =  Teams::find($id);

    return response()->json($content);
  }

  public function getAgendas ($id): JsonResponse {
    $content = Agendas::whereHas('member', function ($query) use ($id) {
      $query->where('team_id', $id);
    })->with('member')->get();

    return response()->json($content);
  }

  public function create (Request $request): JsonResponse {
    $this->validate($request, Teams::$rules);

    $team = new Teams();

    $team->fill($request->all());

    $team->save();

    return response()->json([
      'code' => 200,
      'message' => 'New team is created successfully',
      'data' => $team
    ]);
  }

  public function update (int $id, Request $request): JsonResponse {
    $this->validate($request, Teams::$rules);

    $team = Teams::find($id);

    $team->fill($request->all());

    $team->save();

    return response()->json([
      'code' => 200,
      'message' => 'Team is updated successfully',
      'data' => $team
    ]);
  }

  public function delete (int $id): JsonResponse {
    $team = Teams::find($id);

    $team->delete();

    return response()->json([
      'code' => 200,
      'message' => 'Team is deleted successfully',
      'data' => $team
    ]);
  }

}
