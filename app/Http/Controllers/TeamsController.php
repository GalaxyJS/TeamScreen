<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeamsController extends Controller {
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct () {
    //
  }

  public function getAll () {
    return \App\Models\Teams::all();
  }

  public function create (Request $request) {
    $this->validate($request, \App\Models\Teams::$rules);

    $team = new \App\Models\Teams();

    $team->fill($request->all());

    $team->save();

    return [
      'code' => 200,
      'message' => 'New team is created successfully',
      'data' => $team
    ];
  }

  public function delete ( $id) {
    if (!isset($id)) {
      return response('', 400)->json([
        'message' => 'member id is required',
      ]);
    }

    $team = \App\Models\Teams::find($id);

    $team->delete();

    return [
      'code' => 200,
      'message' => 'Team is deleted successfully',
      'data' => $team
    ];
  }
  //
}
