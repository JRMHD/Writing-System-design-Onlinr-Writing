<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAssignmentsTable extends Migration
{
    public function up()
    {
        Schema::table('assignments', function (Blueprint $table) {
            $table->foreignId('selected_writer_id')->nullable()->constrained('users');
            $table->enum('status', ['open', 'closed', 'in_progress'])->default('open');
        });
    }

    public function down()
    {
        Schema::table('assignments', function (Blueprint $table) {
            $table->dropColumn('selected_writer_id');
            $table->dropColumn('status');
        });
    }
}
