<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('home_team_id')
                ->constrained('teams');
            $table->foreignId('away_team_id')
                ->constrained('teams');
            $table->tinyInteger('goals_home', false, true);
            $table->tinyInteger('goals_away', false, true);
            $table->foreignId('winner_id')
                ->constrained('teams')->nullable();
            $table->tinyInteger('matchweek', false, true);
            // $table->boolean('is_played');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matches');
    }
}
