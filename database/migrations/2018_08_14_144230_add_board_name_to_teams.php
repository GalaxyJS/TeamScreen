<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBoardNameToTeams extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up () {
    Schema::table('teams', function (Blueprint $table) {
      $table->string('board_name')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down () {
    //
    Schema::table('teams', function (Blueprint $table) {
      $table->dropColumn('board_name');
    });
  }
}
