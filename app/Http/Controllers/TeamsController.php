<?php

namespace App\Http\Controllers;

use App\Models\Agendas;
use App\Models\Teams;
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
    return Teams::with('members')->get();
  }

  public function get ($id) {
    return Teams::find($id);
  }

  public function getAgendas ($id) {
    return Agendas::whereHas('member', function ($query) use ($id) {
      $query->where('team_id', $id);
    })->with('member')->get();
  }

  public function create (Request $request) {
    $this->validate($request, Teams::$rules);

    $team = new Teams();

    $team->fill($request->all());

    $team->save();

    return [
      'code' => 200,
      'message' => 'New team is created successfully',
      'data' => $team
    ];
  }

  public function update (Request $request, $id) {
    $this->validate($request, Teams::$rules);

    $team = Teams::find($id);

    $team->fill($request->all());

    $team->save();

    return [
      'code' => 200,
      'message' => 'Team is updated successfully',
      'data' => $team
    ];
  }

  public function delete ($id) {
    if (!isset($id)) {
      return response('', 400)->json([
        'message' => 'member id is required',
      ]);
    }

    $team = Teams::find($id);

    $team->delete();

    return [
      'code' => 200,
      'message' => 'Team is deleted successfully',
      'data' => $team
    ];
  }

}
