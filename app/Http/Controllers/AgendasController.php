<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Agendas;

class AgendasController extends Controller {
  public function get (int $id): JsonResponse {
    $content = Agendas::find($id);

    return response()->json($content);
  }

  public function getAll (): JsonResponse {
    $content = Agendas::all();

    return response()->json($content);
  }

  public function getAllForTeam (int $team_id): JsonResponse {
    $content = Agendas::has('team', $team_id)->get();

    return response()->json($content);
  }

  public function create (Request $request): JsonResponse {
    $this->validate($request, Agendas::$rules);

    $agenda = new Agendas();

    $agenda->fill($request->all());

    $agenda->save();

    return response()->json([
      'code' => 200,
      'message' => 'Time off is created successfully',
      'data' => $agenda
    ]);
  }

  public function update (int $id, Request $request): JsonResponse {
    $this->validate($request, Agendas::$rules);

    $member = Agendas::find($id);

    $member->fill($request->all());

    $member->save();

    return response()->json([
      'code' => 200,
      'message' => 'Time off is updated successfully',
      'data' => $member
    ]);
  }

  public function delete (int $id): JsonResponse {
    $member = Agendas::find($id);

    $member->delete();

    return response()->json([
      'code' => 200,
      'message' => 'Time off is deleted successfully',
      'data' => $member
    ]);
  }
}
