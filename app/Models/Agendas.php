<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agendas extends Model {
  protected $table = 'agendas';

  protected $fillable = [
    'member_id',
    'start_time',
    'end_time',
    'type'
  ];

  protected $dates = [];

  public static $rules = [
    // Validation rules
    'member_id' => 'required',
    'start_time' => 'required|date_format:"Y-m-d H:i"',
    'end_time' => 'required|date_format:"Y-m-d H:i"',
  ];

  // Relationships
  public function member () {
    return $this->belongsTo('App\Models\Members', 'member_id');
  }
}
