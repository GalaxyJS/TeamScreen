<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teams extends Model {
  protected $table = 'teams';

  protected $fillable = [
    'name',
    'board_id',
    'board_name'
  ];

  protected $dates = [];

  public static $rules = [
    'name' => 'required',
    'board_id' => 'required'
  ];

  public function members () {
    return $this->hasMany('App\Models\Members', 'team_id');
  }

  public function agendas () {
    return $this->members()->agendas();
  }
}
