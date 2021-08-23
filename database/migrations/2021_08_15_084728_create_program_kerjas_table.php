<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramKerjasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_kerjas', function (Blueprint $table) {
         	$table->bigIncrements('id');
    		$table->date('tanggal');
    		$table->integer('cabang')->nullable();
    		$table->biginteger('drops')->nullable();
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
        Schema::dropIfExists('program_kerjas');
    }
}
