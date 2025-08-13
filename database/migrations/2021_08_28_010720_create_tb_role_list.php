<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTbRoleList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_role_list', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("role_id")->nullable();
            $table->integer("menu_id")->nullable();
            $table->enum('read',['on','off'])->nullable()->default('off');
            $table->enum('add',['on','off'])->nullable()->default('off');
            $table->enum('edit',['on','off'])->nullable()->default('off');
            $table->enum('delete',['on','off'])->nullable()->default('off');
     
            $table->datetime('created')->nullable();
            $table->datetime('updated')->nullable();
        });

        DB::table('tb_role_list')->insert([
            [ "id" => "1"
            ,"role_id" => "1"
            ,"menu_id" => "1"
            ,"read" => "on"
            ,"add" => "on"
            ,"edit" => "on"
            ,"delete" => "on"
            ,"created" => date('Y-m-d H:i:s')
            , "updated" => date('Y-m-d H:i:s') ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_role_list');
    }
}
