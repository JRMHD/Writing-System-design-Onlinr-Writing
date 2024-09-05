<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('bids', function (Blueprint $table) {
            $table->string('message', 255)->nullable()->after('amount'); // Add message column
        });
    }

    public function down()
    {
        Schema::table('bids', function (Blueprint $table) {
            $table->dropColumn('message'); // Drop message column if rolling back
        });
    }
};
