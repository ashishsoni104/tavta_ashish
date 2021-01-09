<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConnectionUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('connection_users', function (Blueprint $table) {
            $table->increments("id");
            $table->integer("sender_user_id");
            $table->integer("request_user_id");
            $table->tinyInteger("status")->default(0)->comment('0=>pending,1=>accept,2=>decline');
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
        //
    }
}
