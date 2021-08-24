<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColomnComulativeToPerkembangansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::table('perkembangans', function (Blueprint $table) {
    		$table->bigInteger('cum_drops')->nullable()->after('sisa_kas');
    		$table->biginteger('cum_storting')->nullable()->after('cum_drops');
    		$table->biginteger('cum_psp')->nullable()->after('cum_storting');
    		$table->biginteger('cum_drop_tunda')->nullable()->after('cum_psp');
    		$table->biginteger('cum_storting_tunda')->nullable()->after('cum_drop_tunda');
    		$table->biginteger('cum_tkp')->nullable()->after('cum_storting_tunda');
    		$table->biginteger('cum_sisa_kas')->nullable()->after('cum_tkp');

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
    		$table->dropColumn([
    			'cum_drops'
    			,'cum_storting'
    			,'cum_psp'
    			,'cum_drop_tunda'
    			,'cum_storting_tunda'
    			,'cum_tkp'
    			,'cum_sisa_kas'
    		]);
    	});
    }
}
