<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPembahasanFullAndTipeSoalToDetailBankPgTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::table('detail_bank_pg', function (Blueprint $table) {
            $table->text('pembahasan_full')->nullable()->after('pembahasan');
            $table->string('tipe_soal', 50)->nullable()->after('pembahasan_full');        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {   
        Schema::table('detail_bank_pg', function (Blueprint $table) {
            $table->dropColumn(['pembahasan_full', 'tipe_soal']);
        });
    }
}
