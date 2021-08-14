<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKantorCabangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kantor_cabangs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slug');
            $table->string('cabang');
            $table->string('created_by');
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
        Schema::dropIfExists('kantor_cabangs');
    }
}
