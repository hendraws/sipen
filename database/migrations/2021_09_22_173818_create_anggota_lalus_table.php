<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnggotaLalusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('anggota_lalus', function (Blueprint $table) {
    		$table->bigIncrements('id');
    		$table->bigInteger('cabang_id');
    		$table->bigInteger('resort_id');
    		$table->Integer('pasaran');
    		$table->date('tanggal');
    		$table->bigInteger('anggota')->nullable();
    		$table->bigInteger('anggota_kini')->nullable();
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
    	Schema::dropIfExists('anggota_lalus');
    }
}
