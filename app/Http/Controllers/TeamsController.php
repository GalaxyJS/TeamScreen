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
    $team = new \App\Models\Teams();

    $team->fill($request->all());

    $team->save();

    return [
      'code' => 200,
      'message' => 'New team is created successfully',
      'data' => $team
    ];
  }
  //
}
