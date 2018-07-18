<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agendas;

class AgendasController extends Controller {
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct () {
    //
  }

  public function get ($id) {
    return Agendas::find($id);
  }

  public function getAll () {
    return Agendas::all();
  }


  public function getAllForTeam ($team_id) {
    return Agendas::has('team', $team_id)->get();
  }

  public function create (Request $request) {
    $this->validate($request, Agendas::$rules);

    $agenda = new Agendas();

    $agenda->fill($request->all());

    $agenda->save();

    return [
      'code' => 200,
      'message' => 'Time off is created successfully',
      'data' => $agenda
    ];
  }

  public function update (Request $request, $id) {
    $this->validate($request, Agendas::$rules);

    $member = Agendas::find($id);

    $member->fill($request->all());

    $member->save();

    return [
      'code' => 200,
      'message' => 'Time off is updated successfully',
      'data' => $member
    ];
  }

  public function delete ($id) {
    if (!isset($id)) {
      return response('', 400)->json([
        'message' => 'member id is required',
      ]);
    }

    $member = Agendas::find($id);

    $member->delete();

    return [
      'code' => 200,
      'message' => 'Time off is deleted successfully',
      'data' => $member
    ];
  }
  //
}
