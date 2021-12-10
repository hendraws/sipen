<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTargetLalusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	if(!Schema::hasTable('target_lalus') ) {    
    		Schema::create('target_lalus', function (Blueprint $table) {
    			$table->bigIncrements('id');
    			$table->bigInteger('cabang_id');
    			$table->bigInteger('resort_id');
    			$table->Integer('pasaran');
    			$table->date('tanggal');
    			$table->string('target_lalu')->nullable();
    			$table->string('created_by')->nullable();
    			$table->string('updated_by')->nullable();
    			$table->timestamps();
    		});

    	}

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    	Schema::dropIfExists('target_lalus');
    }
}
