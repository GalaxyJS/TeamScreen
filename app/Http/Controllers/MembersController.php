<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MembersController extends Controller {
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct () {
    //
  }

  public function getAll () {
    return \App\Models\Members::all();
  }

  public function getAllForTeam ($team_id) {
    return \App\Models\Members::has('team', $team_id)->get();
  }

  public function create (Request $request) {
    $this->validate($request, \App\Models\Members::$rules);

    $member = new \App\Models\Members();

    $member->fill($request->all());

    $member->save();

    return [
      'code' => 200,
      'message' => 'New member is created successfully',
      'data' => $member
    ];
  }

  public function delete ($id) {
    if (!isset($id)) {
      return response('', 400)->json([
        'message' => 'member id is required',
      ]);
    }

    $member = \App\Models\Members::find($id);

    $member->delete();

    return [
      'code' => 200,
      'message' => 'Member is deleted successfully',
      'data' => $member
    ];
  }
  //
}
