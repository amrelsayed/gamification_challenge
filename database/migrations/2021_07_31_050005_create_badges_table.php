<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBadgesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('badges', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('points');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('badge_id')
                ->default(1)
                ->on('badges')
                ->after('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('badges');

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('badge_id');
        });
    }
}
