<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teams extends Model {
  protected $table = 'teams';

  protected $fillable = [
    'name'
  ];

  protected $dates = [];

  public static $rules = [
    // Validation rules
    'name' => 'required'
  ];

  // Relationships
  public function members () {
    return $this->hasMany('App\Models\Members', 'team_id');
  }
}