<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->enum('type_log',['frontend','backend'])->nullable();
            $table->text('error_log')->nullable();
            $table->integer('error_line')->nullable();
            $table->text('error_url')->nullable();
            $table->datetime('created')->nullable();
            $table->datetime('updated')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_logs');
    }
}
