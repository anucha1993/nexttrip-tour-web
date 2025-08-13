<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class CreateTbMenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_menu', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('_id')->nullable();
            $table->string('name',100)->nullable();
            $table->text('url')->nullable();
            $table->text('icon')->nullable();
            $table->enum('position',['main','secondary'])->nullable();


            $table->integer('sort')->nullable();
            $table->enum('status',['on','off'])->nullable()->default('on');
            $table->enum('delete_status',['on','off'])->nullable()->default('off');
            $table->datetime('created')->nullable();
            $table->datetime('updated')->nullable();
            $table->datetime('deleted')->nullable();
        });

            DB::table('tb_menu')->insert([
            [ "id" => "1"
            ,"_id" => null
            ,"name" => "Test Form"
            ,"url" => "/testform"
            ,"icon" => "home"
            ,"position" => "main"
            ,"sort" => "1"
            ,"status" => "on"
            ,"delete_status" => "off"
            ,"created" => date('Y-m-d H:i:s')
            ,"updated" => date('Y-m-d H:i:s')
            ,"deleted" => null ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_menu');
    }
}
