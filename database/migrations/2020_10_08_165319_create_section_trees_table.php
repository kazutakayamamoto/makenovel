<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectionTreesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('section_trees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('section_number');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('books_id');
            $table->string('content',100);
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
        Schema::dropIfExists('section_trees');
    }
}
