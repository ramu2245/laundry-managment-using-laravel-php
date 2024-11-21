<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddItemIdToItemDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_details', function (Blueprint $table) {
            // Check if the 'item_id' column already exists before adding it
            if (!Schema::hasColumn('item_details', 'item_id')) {
                $table->unsignedBigInteger('item_id'); // Add item_id column
                $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade'); // Foreign key constraint
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('item_details', function (Blueprint $table) {
            // Drop foreign key and column only if they exist
            if (Schema::hasColumn('item_details', 'item_id')) {
                $table->dropForeign(['item_id']);
                $table->dropColumn('item_id');
            }
        });
    }
}
