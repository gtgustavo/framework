<?php

use App\Helpers\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

class PasswordResetMigration extends Migration
{
    public function up()
    {
        $this->schema->create('password_resets', function(Blueprint $table){
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
