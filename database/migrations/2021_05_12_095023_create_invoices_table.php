<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('invoice_number')->unique();
            $table->date('invoive_date');
            $table->date('due_date');
            $table->string('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->string('section_id');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
            $table->decimal('amount_collection',8,2);
            $table->decimal('amount_commission',8,2);
            $table->decimal('discount',8,2)->default(0);
            $table->string('rate_vat');
            $table->decimal('value_vat',8,2);
            $table->decimal('total',8,2);
            $table->string('status',50)->default('غير مدفوعة');
            $table->integer('value_status')->default(1);
            $table->text('note')->nullable();
            $table->string('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
