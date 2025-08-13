<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class CreateTbRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_role', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("name",100)->nullable();
            $table->text("detail")->nullable();
      
            $table->enum('status',['on','off'])->nullable()->default('on');
            $table->datetime('created')->nullable();
            $table->datetime('updated')->nullable();
        });

        DB::table('tb_role')->insert([
            [ "id" => "1","name" => "Administrator","detail" => "Administrator root","status" => "on","created" => date('Y-m-d H:i:s'), "updated" => date('Y-m-d H:i:s') ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_role');
    }
}
