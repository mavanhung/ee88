<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableMienBac45GiayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mien_bac_45_giay', function (Blueprint $table) {
            $table->id();
            $table->string('time');
            $table->string('begin_time');
            $table->string('end_time');
            $table->string('official_time');
            $table->string('last_issue'); //Kỳ hiện tại
            $table->string('issue'); //Kỳ tiếp theo
            $table->string('open_numbers');
            $table->string('open_numbers_formatted');
            $table->string('open_result');
            $table->string('bigSmall');
            $table->string('oddEven');
            $table->string('sumTotalList');
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
        Schema::dropIfExists('mien_bac_45_giay');
    }
}
