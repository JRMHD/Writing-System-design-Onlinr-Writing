<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEmployersTable extends Migration
{
    public function up()
    {
        Schema::table('employers', function (Blueprint $table) {
            $table->boolean('is_public')->default(true); // Add visibility field
            $table->text('bio')->nullable();
            $table->integer('profile_completion')->default(0);
        });
    }

    public function down()
    {
        Schema::table('employers', function (Blueprint $table) {
            $table->dropColumn('is_public');
        });
    }
}
