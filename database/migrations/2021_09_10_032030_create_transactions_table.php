<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('transactions')) {
            Schema::create('transactions', function (Blueprint $table) {
                $table->id();
                
                // Foreign Key to 'services' table
                $table->foreignId('service_id')
                      ->constrained('services')  // 'services' is the referenced table
                      ->onDelete('cascade');     // Cascade delete if service is deleted

                // Foreign Key to 'items' table
                $table->foreignId('item_id')
                      ->constrained('items')    // 'items' is the referenced table
                      ->onDelete('cascade');   // Cascade delete if item is deleted
                
                // Monetary value, use decimal for precision
                $table->decimal('total_payment', 10, 2);  // 10 digits, 2 decimal places for monetary value

                // Status as small integer (use Enum or constants for values like '0' for pending, '1' for completed)
                $table->smallInteger('status')->default(0); // Defaulting to '0' (e.g., '0' = pending)

                // Nullable dates for received and pickup
                $table->dateTime('received_date')->nullable();  // Nullable if optional
                $table->dateTime('pickup_date')->nullable();    // Nullable if optional
                
                // Timestamps for created_at and updated_at
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
