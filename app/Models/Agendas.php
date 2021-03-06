<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

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
    'member_id' => 'required',
    'start_time' => 'required|date_format:"Y-m-d H:i"',
    'end_time' => 'required|date_format:"Y-m-d H:i"',
  ];

  public function member () {
    return $this->belongsTo('App\Models\Members', 'member_id');
  }

  public function getStartTimeAttribute ($value) {
    return Carbon::parse($value)->format('Y-m-d H:i');
  }

  public function getEndTimeAttribute ($value) {
    return Carbon::parse($value)->format('Y-m-d H:i');
  }
}
