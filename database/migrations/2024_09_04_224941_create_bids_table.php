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
        Schema::create('bids', function (Blueprint $table) {
            $table->id();
            $table->foreignId('writer_id')->constrained('writers')->onDelete('cascade'); // References 'writers' table
            $table->foreignId('assignment_id')->constrained('assignments')->onDelete('cascade'); // References 'assignments' table
            $table->decimal('amount', 8, 2); // Make sure the column name is 'amount'
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bids');
    }
};
