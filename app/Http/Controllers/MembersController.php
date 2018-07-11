<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
    return \App\Models\Teams::all();
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
  //
}
