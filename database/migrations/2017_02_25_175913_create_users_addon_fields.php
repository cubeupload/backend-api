<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersAddonFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('registration_ip')->nullable()->after('password');
            $table->integer('access_level')->default(0)->after('registration_ip');
            $table->string('metadata')->default('{}')->after('access_level');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('registration_ip');
            $table->dropColumn('access_level');
            $table->dropColumn('metadata');

        });
    }
}
