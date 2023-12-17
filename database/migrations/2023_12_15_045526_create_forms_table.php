<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->timestamps();
            $table->string("name");
            $table->string("birthdate")->nullable();
            $table->string("height")->nullable();
            $table->string("weight")->nullable();
            $table->string("size")->nullable();
            $table->string("citizenship")->nullable();
            $table->string("visa")->nullable();
            $table->string("tour_date")->nullable();
            $table->string("countries")->nullable();
            $table->string("contact")->nullable();

            $table->boolean("anal_sex")->nullable();
            $table->boolean("cum_in_mouth")->nullable();
            $table->boolean("swallowing")->nullable();
            $table->boolean("cum_on_face")->nullable();
            $table->boolean("cum_on_body")->nullable();
            $table->boolean("blowjob_without_a_condom")->nullable();
            $table->boolean("deep_throat")->nullable();
            $table->boolean("french_kiss")->nullable();
            $table->boolean("fisting")->nullable();
            $table->boolean("rimming")->nullable();
            $table->boolean("rimming_you")->nullable();
            $table->boolean("footjob")->nullable();
            $table->boolean("golden_shower")->nullable();
            $table->boolean("light_domination")->nullable();
            $table->boolean("hard_domination")->nullable();
            $table->boolean("are_you_a_slave")->nullable();
            $table->boolean("married_couple")->nullable();
            $table->boolean("group_sex")->nullable();
            $table->boolean("role_playing_games")->nullable();
            $table->boolean("prostate_massage")->nullable();
            $table->boolean("licking_testicles")->nullable();
            $table->boolean("normal_relax_massage")->nullable();
            $table->boolean("striptease")->nullable();

            $table->boolean('is_posted')->default(false);
            $table->integer('number')->nullable()->unique();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forms');
    }
};
