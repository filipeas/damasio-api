<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('cod');
            $table->unsignedBigInteger('subcategory');
            $table->unsignedBigInteger('group')->nullable();
            $table->text('description');
            $table->text('application');
            $table->string('cover')->nullable();
            $table->timestamps();

            $table->foreign('subcategory')->references('id')->on('categories')->onDelete('CASCADE');
            $table->foreign('group')->references('id')->on('groups')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
