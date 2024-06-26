<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id');
            $table->string('subject')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete("cascade");
        });
        Schema::create('note_attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('note_id');
            $table->string('file_path');
            $table->timestamps();

            $table->foreign('note_id')->references('id')->on('notes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('note_attachments');
        Schema::dropIfExists('notes');
    }
};
