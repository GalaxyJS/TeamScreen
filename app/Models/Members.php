<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Members extends Model {
  protected $table = 'members';

  protected $fillable = [
    'team_id',
    'name',
    'username',
    'destination',
    'drink_preference',
    'working_days'
  ];

  protected $dates = [];

  public static $rules = [
    // Validation rules
  ];

  // Relationships
  public function team () {
    return $this->belongsTo('App\Models\Teams', 'team_id');
  }

  public function agendas () {
    return $this->hasMany('App\Models\Agendas', 'member_id');
  }
}
