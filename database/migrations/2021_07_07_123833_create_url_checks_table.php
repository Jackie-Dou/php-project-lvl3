<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUrlChecksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('url_checks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('url_id');
            $table->unsignedTinyInteger('status_code')->nullable();
            $table->text('h1')->nullable();
            $table->text('keywords')->nullable();
            $table->text('description')->nullable();
            $table->dateTime('created_at', 0);
            $table->dateTime('updated_at', 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('url_checks');
    }
}