<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('ename')->nullable();
            $table->string('product_url');
            $table->integer('price1');
            $table->integer('price2');
            $table->integer('discount_price')->nullable();
            $table->smallInteger('show')->default(1);
            $table->integer('view');
            $table->text('keywords')->nullable();
            $table->text('description')->nullable();
            $table->smallInteger('special')->default(0);
            $table->integer('cat_id');
            $table->string('img_url')->nullable();
            $table->text('tozihat')->nullable();
            $table->integer('order_number')->default(0);
            $table->smallInteger('status')->default(0);
            $table->integer('send_time');
            $table->integer('product_number')->nullable();
            $table->integer('product_number_cart')->nullable();
            $table->integer('roz')->nullable();

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
        Schema::dropIfExists('products');
    }
}
