<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Members;

class MembersController extends Controller {
  public function get (int $id): JsonResponse {
    $content = Members::find($id);

    return response()->json($content);
  }

  public function getAll (): JsonResponse {
    $content = Members::all();

    return response()->json($content);
  }

  public function getAllForTeam (int $team_id): JsonResponse {
    $content = Members::has('team', $team_id)->get();

    return response()->json($content);
  }

  public function create (Request $request): JsonResponse {
    $this->validate($request, Members::$rules);

    $member = new Members();

    $member->fill($request->all());

    $member->save();

    return response()->json([
      'code' => 200,
      'message' => 'New member is created successfully',
      'data' => $member
    ]);
  }

  public function update (int $id, Request $request): JsonResponse {
    $this->validate($request, Members::$rules);

    $member = Members::find($id);

    $member->fill($request->all());

    $member->save();

    return response()->json([
      'code' => 200,
      'message' => 'Member is updated successfully',
      'data' => $member
    ]);
  }

  public function delete (int $id): JsonResponse {
    $member = Members::find($id);

    $member->delete();

    return response()->json([
      'code' => 200,
      'message' => 'Member is deleted successfully',
      'data' => $member
    ]);
  }
}
