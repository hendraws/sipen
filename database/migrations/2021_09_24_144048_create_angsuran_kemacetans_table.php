<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAngsuranKemacetansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('angsuran_kemacetans', function (Blueprint $table) {
    		$table->bigIncrements('id');
    		$table->bigInteger('kemacetan_id')->nullable();
    		$table->bigInteger('cabang_id');
    		$table->bigInteger('resort_id');
    		$table->Integer('pasaran');
    		$table->date('tanggal');
    		$table->bigInteger('angsuran')->nullable();
    		$table->bigInteger('anggota_keluar')->nullable();
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
    	Schema::dropIfExists('angsuran_kemacetans');
    }
}
