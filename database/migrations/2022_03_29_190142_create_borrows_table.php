<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('borrows', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reader_id');
            $table->foreign('reader_id')
                ->references('id')
                ->on('users');
//                ->onDelete('cascade');
            $table->unsignedBigInteger('book_id');
            $table->foreign('book_id')
                ->references('id')
                ->on('books')
                ->onDelete('cascade');
            $table->enum('status', ['PENDING', 'ACCEPTED', 'REJECTED', 'RETURNED']);
            $table->date('request_processed_at')->nullable();
            $table->unsignedBigInteger('request_managed_by')->nullable();
            $table->foreign('request_managed_by')
                ->references('id')
                ->on('users');
//                ->onDelete('cascade');
            $table->unsignedBigInteger('return_managed_by')->nullable();
            $table->foreign('return_managed_by')
                ->references('id')
                ->on('users');
//                ->onDelete('cascade');
            $table->dateTime('deadline')->nullable();
            $table->dateTime('returned_at')->nullable();
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
        Schema::dropIfExists('borrows');
    }
};
