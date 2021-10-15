<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent')->nullable();
            $table->string('title');
            $table->string('pdf')->nullable();
            $table->string('propaganda')->nullable();
            $table->string('title_color')->nullable();
            $table->string('color')->nullable();
            $table->boolean('model')->nullable();
            $table->timestamps();

            $table->foreign('parent')->references('id')->on('categories'); //->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
