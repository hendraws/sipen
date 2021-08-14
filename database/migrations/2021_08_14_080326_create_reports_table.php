<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('reports', function (Blueprint $table) {
    		$table->bigIncrements('id');
    		$table->date('tanggal');
    		$table->integer('cabang')->nullable();
    		$table->biginteger('drop')->nullable();
    		$table->biginteger('storting')->nullable();
    		$table->biginteger('psp')->nullable();
    		$table->biginteger('drop_tunda')->nullable();
    		$table->biginteger('storting_tunda')->nullable();
    		$table->biginteger('tkp')->nullable();
    		$table->biginteger('sisa_kas')->nullable();
    		$table->string('created_by')->nullable();
    		$table->string('updated_by')->nullable();
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
    	Schema::dropIfExists('reports');
    }
}
