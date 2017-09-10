<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleArchivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_archives', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('article_id');
            $table->string('sub_title', 255);
            $table->string('title', 255);
            $table->integer('language');
            $table->longtext('body');
            $table->text('keywords');
            $table->integer('published');
            $table->integer('situation');
            $table->integer('version');
            $table->softDeletes();
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
        Schema::dropIfExists('article_olds');
    }
}
