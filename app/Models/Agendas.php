<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agendas extends Model {
  protected $table = 'members';

  protected $fillable = [
    'member_id',
    'start_time',
    'end_time',
    'type'
  ];

  protected $dates = [];

  public static $rules = [
    // Validation rules
  ];

  // Relationships
  public function member () {
    return $this->belongsTo('App\Models\Member', 'member_id');
  }
}
