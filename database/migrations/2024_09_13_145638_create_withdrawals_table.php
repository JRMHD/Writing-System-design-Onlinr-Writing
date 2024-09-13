<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrawalsTable extends Migration
{
    public function up()
    {
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('writer_id');
            $table->decimal('amount', 10, 2);
            $table->string('status')->default('pending');  // Pending, Approved, Rejected
            $table->timestamps();

            $table->foreign('writer_id')->references('id')->on('writers')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('withdrawals');
    }
}
