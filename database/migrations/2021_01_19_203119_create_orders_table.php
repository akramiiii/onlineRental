<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('date');
            $table->integer('user_id');
            $table->integer('address_id');
            $table->string('pay_status' , 100);
            $table->integer('total_price');
            $table->integer('price');
            $table->string('order_id');
            $table->string('pay_code1')->nullable();
            $table->string('pay_code2')->nullable();
            $table->string('order_read');
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
        Schema::dropIfExists('orders');
    }
}
