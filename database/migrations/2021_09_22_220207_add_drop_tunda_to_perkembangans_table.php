<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDropTundaToPerkembangansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


    	if(Schema::hasTable('perkembangans') ) {
    		Schema::table('perkembangans', function (Blueprint $table) {
            	  $table->integer('drop_tunda_masuk')->nullable()->default(0)->after('drop_tunda');
            	  $table->integer('drop_tunda_keluar')->nullable()->default(0)->after('drop_tunda_masuk'); 
            	  $table->integer('angsuran_tunda_masuk')->nullable()->default(0)->after('storting_tunda');
            	  $table->integer('angsuran_tunda_keluar')->nullable()->default(0)->after('angsuran_tunda_masuk');

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
    	Schema::table('perkembangans', function (Blueprint $table) {
            //
    	});
    }
}
