<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTargetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('targets', function (Blueprint $table) {
    		$table->bigIncrements('id');
    		$table->bigInteger('cabang_id');
    		$table->bigInteger('resort_id');
    		$table->Integer('pasaran');
    		$table->date('tanggal');
    		$table->bigInteger('anggota_lalu')->nullable()->default(0);
    		$table->bigInteger('anggota_lama')->nullable()->default(0);
    		$table->bigInteger('anggota_baru')->nullable()->default(0);
    		$table->bigInteger('anggota_out')->nullable()->default(0);
    		$table->bigInteger('anggota_kini')->nullable()->default(0);
    		$table->bigInteger('target_lalu')->nullable()->default(0);
    		$table->bigInteger('target_20_drop')->nullable()->default(0);
    		$table->bigInteger('target_20_plnsn')->nullable()->default(0)->comment('pelunasan');
    		$table->bigInteger('target_kini')->nullable()->default(0);
    		$table->bigInteger('target_drops')->nullable()->default(0)->comment('pelunasan');
    		$table->bigInteger('target_plnsn')->nullable()->default(0)->comment('pelunasan');
    		$table->bigInteger('drop_lalu')->nullable()->default(0);
    		$table->bigInteger('drop_kini')->nullable()->default(0);
    		$table->bigInteger('drop_berjalan')->nullable()->default(0);
    		$table->bigInteger('drop_total')->nullable()->default(0);
    		$table->bigInteger('storting_lalu')->nullable()->default(0);
    		$table->bigInteger('storting_kini')->nullable()->default(0);
    		$table->bigInteger('storting_berjalan')->nullable()->default(0);
    		$table->bigInteger('storting_total')->nullable()->default(0);
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
    	Schema::dropIfExists('targets');
    }
}
