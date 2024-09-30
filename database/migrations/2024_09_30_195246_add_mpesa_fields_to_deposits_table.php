<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMpesaFieldsToDepositsTable extends Migration
{
    public function up()
    {
        Schema::table('deposits', function (Blueprint $table) {
            $table->string('mpesa_transaction_id')->nullable()->after('amount');
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending')->after('mpesa_transaction_id');
        });
    }

    public function down()
    {
        Schema::table('deposits', function (Blueprint $table) {
            $table->dropColumn(['mpesa_transaction_id', 'status']);
        });
    }
}
