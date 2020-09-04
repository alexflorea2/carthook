<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_posts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('api_user_id')->index();
            $table->bigInteger('api_id')->unique();
            $table->string('title')->index();
            $table->text('body');
            $table->dateTime('cached_at')->useCurrent();
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
        Schema::dropIfExists('api_posts');
    }
}
