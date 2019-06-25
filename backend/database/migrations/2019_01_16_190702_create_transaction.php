<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('from_account_id');
            $table->unsignedInteger('to_account_id');
            $table->unsignedInteger('operation_id');
            $table->unsignedInteger('order');
            $table->unsignedDecimal('amount');
            $table->unsignedTinyInteger('type')->index();
            $table->unsignedTinyInteger('status')->index();
            $table->timestamps();

            $table->foreign('from_account_id')
                ->references('id')
                ->on('accounts')
                ->onDelete('cascade')
            ;

            $table->foreign('operation_id')
                ->references('id')
                ->on('operations')
                ->onDelete('cascade')
            ;

            $table->foreign('to_account_id')
                ->references('id')
                ->on('accounts')
                ->onDelete('cascade')
            ;
        });
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
