<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDbTicketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('db_ticket', function (Blueprint $table) {
            $table->string('id_ticket')->primary();
            $table->date('tanggal_dibuat');
            $table->date('tanggal_solved')->nullable();
            $table->string('id_user');
            $table->string('kategori');
            $table->longText('problem_detail')->nullable();
            $table->string('assigned')->nullable();
            $table->string('status');
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
        Schema::dropIfExists('db_ticket');
    }
}
