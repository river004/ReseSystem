<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // 店名
        $table->string('image')->nullable(); // 店舗画像
        $table->text('description')->nullable(); // 店舗概要
        $table->unsignedBigInteger('area_id'); // エリアID
        $table->unsignedBigInteger('genre_id'); // ジャンルID
        $table->unsignedBigInteger('owner_id'); // 店舗代表者ID
        $table->timestamps();

        $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('area_id')->references('id')->on('areas')->onDelete('cascade');
        $table->foreign('genre_id')->references('id')->on('genres')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stores');
    }
}
