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
            $table->increments('id');
            $table->integer('users_id');
            $table->string('users_email',100);
            $table->string('name',100);
            $table->string('address');
            $table->string('city',100);
            $table->string('state',100)->nullable();
            $table->string('pincode',100)->nullable();
            $table->string('country',100);
            $table->string('mobile',100);
            $table->float('shipping_charges');
            $table->string('coupon_code',100);
            $table->string('coupon_amount',100);
            $table->string('order_status',100);
            $table->string('payment_method',100);
            $table->string('grand_total',100);
            $table->tinyInteger('status')->default(0);
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
