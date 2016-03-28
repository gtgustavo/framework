<?php

use \App\Helpers\Migration\Migration;

class Password extends Migration
{
    public function up()
    {
        $this->schema->create('password_resets', function(Illuminate\Database\Schema\Blueprint $table){
            $table->increments('id', 11);
            $table->string('email')->index();
            $table->string('token')->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        $this->schema->drop('password_resets');
    }
}
