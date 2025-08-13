<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbTestform extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_testform', function (Blueprint $table) {
            $table->id();
            $table->string('name',100)->nullable();

            $table->integer('sort')->nullable();
            $table->enum('status',['on','off'])->nullable()->default('on');
            $table->enum('delete_status',['on','off'])->nullable()->default('off');
            $table->datetime('created_at')->nullable();
            $table->datetime('updated_at')->nullable();
            $table->datetime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_testform');
    }
}
