<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up () {
    Schema::create('members', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('team_id');
      $table->string('name');
      $table->string('username');
      $table->string('destination');
      $table->string('drink_preference');
      $table->string('working_days');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down () {
    Schema::dropIfExists('members');
  }
}
