<?php

use \App\Helpers\Migration\Migration;

class Users extends Migration
{
    public function up()
    {
        $this->schema->create('users', function(Illuminate\Database\Schema\Blueprint $table){
            $table->increments('id', 11);
            $table->string('name', 30);
            $table->string('phone', 11);
            $table->enum('type_card', ['V', 'E'])->default('V');
            $table->integer('id_card')->length(9)->unsigned()->unique();
            $table->string('email', 30)->unique();
            $table->string('password', 60);
            $table->enum('role', ['admin', 'user'])->default('user');
            $table->timestamps();
        });
    }
    public function down()
    {
        $this->schema->drop('users');
    }
}
