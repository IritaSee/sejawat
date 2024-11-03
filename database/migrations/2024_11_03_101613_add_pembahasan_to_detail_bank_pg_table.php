<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPembahasanToDetailBankPgTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detail_bank_pg', function (Blueprint $table) {
            $table->text('pembahasan')->nullable()->after('jawaban')
                ->comment('Pembahasan atau penjelasan untuk soal pilihan ganda');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_bank_pg', function (Blueprint $table) {
            $table->dropColumn('pembahasan');
        });
    }
}
