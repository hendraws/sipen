<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalonMacetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('calon_macets', function (Blueprint $table) {
    		$table->bigIncrements('id');
    		$table->bigInteger('cabang_id');
    		$table->bigInteger('resort_id');
    		$table->Integer('pasaran');
    		$table->date('tanggal');
    		$table->bigInteger('cma_anggota')->comment('cma = Calon Macet Awal');
    		$table->bigInteger('cma_pinjaman')->comment('cma = Calon Macet Awal');
    		$table->bigInteger('cma_target')->comment('cma = Calon Macet Awal');
    		$table->bigInteger('cma_saldo')->comment('cma = Calon Macet Awal'); 
    		$table->bigInteger('cmk_anggota')->nullable()->default(0)->comment('cmk = Calon Macet Kini');
    		$table->bigInteger('cmk_pinjaman')->nullable()->default(0)->comment('cmk = Calon Macet Kini');
    		$table->bigInteger('cmk_target')->nullable()->default(0)->comment('cmk = Calon Macet Kini');
    		$table->bigInteger('cmk_saldo')->nullable()->default(0)->comment('cmk = Calon Macet Kini');
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
    	Schema::dropIfExists('calon_macets');
    }
}
