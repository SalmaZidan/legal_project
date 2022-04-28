<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->string('year');
            $table->tinyInteger('day');
            $table->unsignedBigInteger('governorate_id')->nullable();
            $table->unsignedBigInteger('court_id')->nullable();
            $table->string('authorization_number');
            $table->string('documentation_number');
            $table->date('date');
            $table->integer('agent_class');
            $table->unsignedBigInteger('issue_type_id')->nullable();
            $table->text('details');
            $table->string('cost');
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
        Schema::dropIfExists('issues');
    }
};
