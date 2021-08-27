<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHariKerjaOnPerkembangansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('perkembangans', function (Blueprint $table) {
    		$table->integer('hari_kerja')->nullable()->after('sisa_kas');

    	});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('perkembangans', function (Blueprint $table) {
            $table->dropColumn('hari_kerja');
        });
    }
}
