<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Members;

class MembersController extends Controller {
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct () {
    //
  }

  public function get ($id) {
    return Members::find($id);
  }

  public function getAll () {
    return Members::all();
  }

  public function getAllForTeam ($team_id) {
    return Members::has('team', $team_id)->get();
  }

  public function create (Request $request) {
    $this->validate($request, Members::$rules);

    $member = new Members();

    $member->fill($request->all());

    $member->save();

    return [
      'code' => 200,
      'message' => 'New member is created successfully',
      'data' => $member
    ];
  }

  public function update (Request $request, $id) {
    $this->validate($request, Members::$rules);

    $member = Members::find($id);

    $member->fill($request->all());

    $member->save();

    return [
      'code' => 200,
      'message' => 'Member is updated successfully',
      'data' => $member
    ];
  }

  public function delete ($id) {
    if (!isset($id)) {
      return response('', 400)->json([
        'message' => 'member id is required',
      ]);
    }

    $member = Members::find($id);

    $member->delete();

    return [
      'code' => 200,
      'message' => 'Member is deleted successfully',
      'data' => $member
    ];
  }
  //
}
