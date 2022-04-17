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
            $table->string('governorate');
            $table->unsignedBigInteger('court_id')->nullable();
            $table->string('authorization_number');
            $table->string('documentation_number');
            $table->date('date');
            $table->integer('agent_class');
            $table->unsignedBigInteger('issue_type_id')->nullable();
            $table->string('cost');
            $table->unsignedBigInteger('agent_id')->nullable();
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
