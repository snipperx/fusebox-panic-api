<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('http_request_log', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->string('method');
            $table->ipAddress('ip');
            $table->json('request_headers');
            $table->boolean('is_successful');
            $table->integer('user_id');
            $table->json('request_body')->nullable();
            $table->unsignedSmallInteger('response_status');
            $table->text('response_body')->nullable();
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
        Schema::dropIfExists('http_request_log');
    }
};
