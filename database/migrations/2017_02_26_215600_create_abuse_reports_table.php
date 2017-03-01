<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbuseReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abuse_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('creator_id');
            $table->string('name', 50);
            $table->string('email', 50);
            $table->string('text', 200);
            $table->integer('actioner_id');
            $table->enum('status', ['open', 'closed']);
            $table->enum('result', ['approved', 'rejected']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('abuse_reports');
    }
}
