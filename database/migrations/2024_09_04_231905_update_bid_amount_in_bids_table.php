<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBidAmountInBidsTable extends Migration
{
    public function up()
    {
        Schema::table('bids', function (Blueprint $table) {
            $table->decimal('bid_amount', 8, 2)->default(0.00)->change(); // Set default value
        });
    }

    public function down()
    {
        Schema::table('bids', function (Blueprint $table) {
            $table->decimal('bid_amount', 8, 2)->change(); // Revert changes
        });
    }
}
