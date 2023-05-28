<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUangKasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uang_kas', function (Blueprint $table) {
            $table->increments('id');
            $table->date('tanggal');
            $table->string('keterangan');
            $table->decimal('debit', 8, 2)->nullable();
            $table->decimal('kredit', 8, 2)->nullable();
            $table->decimal('saldo', 8, 2);
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
        Schema::dropIfExists('uang_kas');
    }
}
