<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKemacetansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kemacetans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('cabang_id');
            $table->bigInteger('resort_id');
            $table->Integer('pasaran');
            $table->date('tanggal');
            $table->bigInteger('ma_anggota')->comment('ma = Macet Awal');
            $table->bigInteger('ma_pinjaman')->comment('ma = Macet Awal');
            $table->bigInteger('ma_target')->comment('ma = Macet Awal');
            $table->bigInteger('ma_saldo')->comment('ma = Macet Awal'); 
            $table->bigInteger('mb_anggota')->comment('mb = Macet Baru');
            $table->bigInteger('mb_pinjaman')->comment('mb = Macet Baru');
            $table->bigInteger('mb_target')->comment('mb = Macet Baru');
            $table->bigInteger('mb_saldo')->comment('mb = Macet Baru');
    		$table->string('created_by')->nullable();
    		$table->string('updated_by')->nullable();
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
        Schema::dropIfExists('kemacetans');
    }
}
