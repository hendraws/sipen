<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalSaldoToKemacetansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kemacetans', function (Blueprint $table) {
             $table->integer('target')->nullable()->default(0)->after('mb_saldo');
	    	  $table->integer('sisa_hk')->nullable()->default(0)->after('mb_saldo');
	    	  $table->integer('sisa_angsuran')->nullable()->default(0)->after('mb_saldo'); 
			  $table->integer('total_saldo')->nullable()->default(0)->after('mb_saldo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kemacetans', function (Blueprint $table) {
            //
        });
    }
}
