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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('title', 128);
            $table->string('comission_number', 128)->unique();
            $table->string('date', 128);
            $table->integer('user_id');
            $table->integer('total_people');
            $table->integer('total_women');
            $table->integer('total_men');
            $table->integer('total_ethnicity');
            $table->integer('total_deshabilities');
            $table->integer('city_id');
            $table->integer('region_id');
            $table->integer('agreement_id');
            $table->text('inform', 2500);
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
