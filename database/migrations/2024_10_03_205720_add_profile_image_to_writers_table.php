<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfileImageToWritersTable extends Migration
{
    public function up()
    {
        Schema::table('writers', function (Blueprint $table) {
            // Add the profile_image column as a nullable string
            $table->string('profile_image')->nullable()->after('skills'); // Adjust the placement as needed
        });
    }

    public function down()
    {
        Schema::table('writers', function (Blueprint $table) {
            // Drop the profile_image column if the migration is rolled back
            $table->dropColumn('profile_image');
        });
    }
}
