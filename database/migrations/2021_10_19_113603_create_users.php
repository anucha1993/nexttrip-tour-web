<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("role")->nullable();
            $table->string('name',200)->nullable();
            $table->string('email',200)->nullable();
            $table->string('password',255)->nullable();
            $table->string('remember_token',255)->nullable();
            $table->text('detail')->nullable();
            $table->enum('status',['pending','inactive','active','banned'])->nullable()->default('active');
    
            $table->datetime('last_login')->nullable();
            $table->datetime('created')->nullable();
            $table->datetime('updated')->nullable();
        });

        // Insert some stuff
        DB::table('users')->insert([
            [
                'role' => '1',
                'name' => 'Orange',
                'email' => 'orange_dev',
                'password' => bcrypt('1234'),
                'status' => 'active',
                'created' => date('Y-m-d H:i:s'),
                'updated' => date('Y-m-d H:i:s'), 
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
