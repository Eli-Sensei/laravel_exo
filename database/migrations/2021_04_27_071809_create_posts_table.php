<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("title");
            $table->string("slug")->unique();
            $table->string("seo_title");
            $table->text("excerpt");
            $table->text("body");
            $table->text("meta_description");
            $table->text("meta_keyword");
            $table->boolean("active")->default(false);
            $table->string("image")->nullable();
            /**
             *  Une catégorie peut avoir plusieurs articles et un article peut avoir plusieurs categories => OneToMany
             *  Un post peut avoir plusieurs tags et un tag peut avoir plusieurs posts => ManyToMany
            */
            $table->foreignId("user_id")->constrained()->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
